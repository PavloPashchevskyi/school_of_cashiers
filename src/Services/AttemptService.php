<?php
declare(strict_types=1);

namespace App\Services;

use App\Repository\UserRepository;
use App\Entity\User;

class AttemptService
{
    /** @var UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUsersAttempts(): array
    {
        /** @var User[] $users */
        $users = $this->userRepository->findAll();

        $result = [];
        /** @var User $user */
        foreach ($users as $i => $user) {
            $result[$i] = [
                'name' => $user->getName(),
                'city' => $user->getCity(),
                'email' => $user->getEmail(),
                'phone' => $user->getPhone(),
            ];
            $result[$i]['attempts'] = [];
            foreach ($user->getAttempts() as $attempt) {
                $result[$i]['attempts'][] = [
                    'test_name' => $attempt->getTest()->getName(),
                    'start_timestamp' => $attempt->getStartTimestamp(),
                    'end_timestamp' => $attempt->getEndTimestamp(),
                    'number_of_points' => $attempt->getNumberOfPoints(),
                ];
            }
        }

        return $result;
    }
}
