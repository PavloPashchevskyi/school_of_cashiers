<?php
declare(strict_types=1);

namespace App\Services;

use App\Entity\User;
use App\Repository\UserRepository;
use DateTime;
use Exception;

class UserService
{
    /** @var UserRepository */
    private $userRepository;
    
    private const TOKEN_TTL = 32400;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    
    /**
     * 
     * @param array $authenticationData
     * @return array
     * @throws Exception
     */
    public function authenticate(array $authenticationData): array
    {
        $guest = $this->userRepository->findOneBy(['login' => $authenticationData['login']]);

        if (!($guest instanceof User)) {
            throw new Exception('Логин указан неверно', 1);
        }

        $result = [];
        if ($guest->getPassword() === $authenticationData['password']) {
            $token = md5(json_encode(['guest_id' => $guest->getId(),]));
            $result = [
                'guest_id' => $guest->getId(),
                'token' => $token,
            ];

            $guest->setApiToken($token);
            $currentTimestamp = (new DateTime())->format('U');
            $guest->setApiTokenValidUntil($currentTimestamp + self::TOKEN_TTL);
            $this->userRepository->store($guest);
        }

        return $result;
    }
    
    /**
     * 
     * @param array $authData
     * @return array
     * @throws Exception
     */
    public function check(array $authData): array
    {
        // check timestamps
        $currentTimestamp = (new DateTime())->format('U');
        if ($currentTimestamp - $authData['timestamp'] > 5) {
            throw new Exception('Превышен интервал ожидания для запроса', 5);
        }

        // check ID of HR-manager
        $guest = $this->userRepository->find($authData['guest_id']);
        if (!($guest instanceof User)) {
            throw new Exception('Пользователь НЕ авторизован или время сеанса истекло!', 3);
        }

        if ($guest->getApiToken() !== $authData['token'] || $guest->getApiTokenValidUntil() < $currentTimestamp) {
            throw new Exception('Пользователь НЕ авторизован или время сеанса истекло!', 3);
        }
        
        return [
            'guest_id' => $authData['guest_id'],
            'token' => $authData['token'],
        ];
    }
    
    /**
     * 
     * @param array $authData
     * @return array
     */
    public function logout(array $authData): array
    {
        $guest = $this->userRepository->find($authData['guest_id']);
        $guest->setApiToken(null);
        $guest->setApiTokenValidUntil(null);
        $this->userRepository->store($guest);

        return [
            'code' => 0,
            'message' => 'OK',
        ];
    }

    /**
     * 
     * @return array
     */
    public function list(): array
    {
        $users = $this->userRepository->getAllUsersList();
        $usersArray = [];
        /** @var \App\Entity\User $user */
        foreach ($users as $i => $user) {
            $usersArray[$i] = [
                'id' => $user->getId(),
                'name' => $user->getName(),
                'city' => $user->getCity(),
                'phone' => $user->getPhone(),
                'guest_login' => $user->getLogin(),
                'guest_password' => $user->getPassword(),
                'guest_data' => $user->getProfile(),
            ];
        }
        
        uasort($usersArray, function (array $userItem1, array $userItem2) {
            $left = $userItem1['guest_data']['createdAt'];
            $right = $userItem2['guest_data']['createdAt'];
            if ($left > $right) {
                return 1;
            }
            if ($left == $right) {
                return 0;
            }
            if ($left < $right) {
                return -1;
            }
        });
        
        return $usersArray;
    }

    /**
     * 
     * @param array $data
     * @return int
     * @throws Exception
     */
    public function store(array $data): int
    {
        $user = $this->userRepository->findOneBy(['name' => $data['name'], 'phone' => $data['phone']]);
        if ($user instanceof User) {
            throw new Exception('Такой пользователь уже существует', 4);       
        }

        $user = new User();
        $user->setName($data['name']);
        $user->setCity($data['city']);
        $user->setPhone($data['phone']);
        
        $user->setLogin('guest_'.(new DateTime())->format('U'));
        
        $user->setPassword($data['password']);
        
        $user->setProfile($data['guest_data']);
        $this->userRepository->store($user);
        
        return $user->getId();
    }
    
    public function updateLearningStatuses(array $data): void
    {
        $guest = $this->userRepository->find($data['guest_id']);
        
        if (!($guest instanceof User)) {
            throw new Exception('Пользователь с таким ID НЕ найден!', 3);
        }
        
        $existingGuestData = $guest->getProfile();
        $newGuestData = $data['guest_data'];
        $existingGuestData['allMaterials'] = $newGuestData['allMaterials'];
        $existingGuestData['allTests'] = $newGuestData['allTests'];
        
        $guest->setProfile($existingGuestData);
        $this->userRepository->store($guest);
    }
}
