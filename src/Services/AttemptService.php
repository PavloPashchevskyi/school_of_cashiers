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
            throw new Exception('Пользователь с таким ID НЕ найден!', 1);
        }
        if (!($test instanceof Test)) {
            throw new Exception('Тест с таким ID НЕ найден!', 1);
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
        $result['link'] = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/api/'.$result['attempt_id'].'/questions/?signature='.$signature;

        return $result;
    }

    /**
     * 
     * @param int $attemptId
     * @param int $currentStage
     * @return int
     * @throws Exception
     */
    public function increaseStage(int $attemptId, int $currentStage): int
    {
        /** @var Attempt $attempt */
        $attempt = $this->attemptRepository->find($attemptId);
        if (!($attempt instanceof Attempt)) {
            throw new Exception('Попытка с таким ID НЕ была зарегистрирована HR-менеджером!', 1);
        }
        if ($currentStage < 1 || $currentStage > 3) {
            throw new Exception('Неверный номер шага теста', 6);
        }
        if ($attempt->getStage() === 0) {
            throw new Exception('Данный тест уже пройден. Невозможно пройти его еще раз!', 2);
        }
        if (($currentStage - $attempt->getStage()) > 1 || $currentStage < $attempt->getStage()) {
            throw new Exception('Данный этап теста уже пройден. Невозможно пройти его ещё раз!', 2);
        }
        $attempt->setStage(($currentStage < 3) ? $currentStage + 1 : 0);
        $this->attemptRepository->store($attempt);

        return $attempt->getStage();
    }
}
