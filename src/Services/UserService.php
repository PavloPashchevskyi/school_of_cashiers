<?php
declare(strict_types=1);

namespace App\Services;

use App\Entity\Attempt;
use App\Entity\User;
use App\Repository\AttemptRepository;
use App\Repository\TestRepository;
use App\Repository\UserRepository;
use DateTime;

class UserService
{
    /** @var UserRepository */
    private $userRepository;

    /** @var TestRepository */
    private $testRepository;

    /** @var AttemptRepository */
    private $attemptRepository;

    private const ATTEMPT_HOST = 'https://school1.kitgroup.org';

    public function __construct(UserRepository $userRepository, TestRepository $testRepository, AttemptRepository $attemptRepository)
    {
        $this->userRepository = $userRepository;
        $this->testRepository = $testRepository;
        $this->attemptRepository = $attemptRepository;
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
                'attempts_quantity' => $user->getAttempts()->count(),
            ];
        }
        
        return $usersArray;
    }

    /**
     * @param array $data
     * @return array
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function store(array $data): array
    {
        $user = new User();
        $user->setName($data['name']);
        $user->setCity($data['city']);
        $user->setPhone($data['phone']);

        $this->userRepository->store($user);

        // create attempt
        $tests = $this->testRepository->findAll();
        $result = [];
        foreach ($tests as $i => $test) {
            $attempt = new Attempt();
            $attempt->setUser($user);
            $attempt->setTest($test);
            $this->attemptRepository->preSave($attempt);
            if (empty($attempt->getId())) {
                $this->attemptRepository->save();
            }
            $result[$i] = [
                'attempt_id' => $attempt->getId(),
                'current_date' => (new DateTime())->format('Ymd'),
                'user' => $this->userRepository->getUserInfo($attempt->getUser()),
            ];
            $result[$i]['test'] = $this->testRepository->getTestInfo($attempt->getTest());

            $signature = md5(json_encode($result[$i]));
            $link = self::ATTEMPT_HOST.'/cashier/'.$result[$i]['attempt_id'].'/'.$signature;

            $attempt->setLink($link);
            $this->attemptRepository->preSave($attempt);
            $result[$i]['link'] = $link;
        }

        $this->attemptRepository->save();
        
        return $result;
    }
}
