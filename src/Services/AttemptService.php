<?php
declare(strict_types=1);

namespace App\Services;

use App\Repository\UserRepository;
use App\Repository\TestRepository;
use App\Repository\AttemptRepository;
use App\Entity\User;
use App\Entity\Test;
use Exception;
use App\Entity\Attempt;

class AttemptService
{
    /** @var UserRepository */
    private $userRepository;

    /** @var TestRepository */
    private $testRepository;

    /** @var AttemptRepository */
    private $attemptRepository;

    public function __construct(UserRepository $userRepository, TestRepository $testRepository, AttemptRepository $attemptRepository)
    {
        $this->userRepository = $userRepository;
        $this->testRepository = $testRepository;
        $this->attemptRepository = $attemptRepository;
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

    /**
     * @param array $dataToFindBy
     * @return array
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function prepare(array $dataToFindBy): array
    {
        $user = $this->userRepository->find($dataToFindBy['userId']);
        $test = $this->testRepository->find($dataToFindBy['testId']);

        if (!($user instanceof User)) {
            throw new Exception('User with this ID has not been found!', 1);
        }
        if (!($test instanceof Test)) {
            throw new Exception('Test with this ID has not been found!', 1);
        }

        $attempt = new Attempt();
        $attempt->setUser($user);
        $attempt->setTest($test);

        $this->attemptRepository->store($attempt);

        $result = [
            'attempt_id' => $attempt->getId(),
            'current_date' => (new \DateTime())->format('Ymd'),
            'user' => $this->userRepository->getUserInfo($attempt->getUser()),
            'test' => $this->testRepository->getTestInfo($attempt->getTest()),
        ];

        $signature = md5(json_encode($result));
        $result['link'] = 'https://'.$_SERVER['SERVER_NAME'].'/attempt/?attempt_id='.$result['attempt_id'].'&signature='.$signature;

        return $result;
    }
}
