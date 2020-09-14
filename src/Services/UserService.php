<?php
declare(strict_types=1);

namespace App\Services;

use App\Entity\User;
use App\Repository\UserRepository;

class UserService
{
    /** @var UserRepository */
    private $userRepository;
    
    /** @const string */
    private const ATTEMPT_HOST = 'https://school1.kitgroup.org';

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
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
                'link' => $user->getLink(),
            ];
        }
        
        return $usersArray;
    }

    /**
     * @param array $data
     * @return int
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function store(array $data): int
    {
        $user = new User();
        $user->setName($data['name']);
        $user->setCity($data['city']);
        $user->setPhone($data['phone']);

        $this->userRepository->store($user);
        $link = self::ATTEMPT_HOST.'/cashier/'.$user->getId();
        $user->setLink($link);
        $this->userRepository->store($user);
        
        return $user->getId();
    }
}
