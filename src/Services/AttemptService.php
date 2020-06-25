<?php
declare(strict_types=1);

namespace App\Services;

use App\Repository\UserRepository;
use App\Entity\User;
use Exception;

class AttemptService
{
    /** @var UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUserAttempts(int $userId): array
    {
        $user = $this->userRepository->find($userId);

        if (!($user instanceof User)) {
            throw new Exception('User with ID#'.$userId.' has not been found!', 1);
        }
        $result = [
            'name' => $user->getName(),
            'city' => $user->getCity(),
            'email' => $user->getEmail(),
            'phone' => $user->getPhone(),
        ];
        $result['attempts'] = [];
        foreach ($user->getAttempts() as $attempt) {
            $result['attempts'][] = [
                'test_name' => $attempt->getTest()->getName(),
                'start_timestamp' => $attempt->getStartTimestamp(),
                'end_timestamp' => $attempt->getEndTimestamp(),
                'number_of_points' => $attempt->getNumberOfPoints(),
            ];
        }

        return $result;
    }
}
