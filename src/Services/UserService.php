<?php
declare(strict_types=1);

namespace App\Services;

use App\Entity\User;
use App\Repository\UserRepository;

class UserService
{
    /** @var UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return array|int|string
     */
    public function list()
    {
        return $this->userRepository->getAllUsersList();
    }

    /**
     * @param array $data
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @return int|null ID of User created
     */
    public function store(array $data): ?int
    {
        $user = new User();
        $user->setName($data['name']);
        $user->setCity($data['city']);
        if (!empty($data['email'])) {
            $user->setEmail($data['email']);
        }
        $user->setPhone($data['phone']);

        $this->userRepository->store($user);
        
        return $user->getId();
    }
}
