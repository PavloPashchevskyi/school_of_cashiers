<?php
declare(strict_types=1);

namespace App\Services;

use App\Repository\UserRepository;
use App\Repository\TestRepository;
use App\Repository\AttemptRepository;
use App\Repository\AnswerRepository;
use App\Entity\User;
use App\Entity\Test;
use Exception;
use App\Entity\Attempt;
use App\Entity\Question;
use App\Entity\Variant;
use App\Entity\Answer;
use DateTime;

class AttemptService
{
    /** @var UserRepository */
    private $userRepository;

    /** @var TestRepository */
    private $testRepository;

    /** @var AttemptRepository */
    private $attemptRepository;
    
    /** @var AnswerRepository */
    private $answerRepository;

    private const ATTEMPT_HOST = 'https://school1.kitgroup.org';

    public function __construct(
        UserRepository $userRepository,
        TestRepository $testRepository,
        AttemptRepository $attemptRepository,
        AnswerRepository $answerRepository
    ) {
        $this->userRepository = $userRepository;
        $this->testRepository = $testRepository;
        $this->attemptRepository = $attemptRepository;
        $this->answerRepository = $answerRepository;
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
     * @param int $userId
     * @return array
     * @throws Exception
     */
    public function getUserAttempts(int $userId): array
    {
        /** @var User $user */
        $user = $this->userRepository->find($userId);

        if (!($user instanceof User)) {
            throw new Exception('Пользователь с таким ID НЕ найден!', 1);
        }

        /** @var Attempt[] $attempts */
        $attempts = $user->getAttempts();

        $attemptsArray = [];
        foreach ($attempts as $i => $attempt) {
            $attemptsArray[$i] = [
                'test' => $attempt->getTest()->getName(),
                'created_at' => $attempt->getCreatedAt(),
                'link' => $attempt->getLink(),
            ];
        }
        
        return $attemptsArray;
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
            'current_date' => (new DateTime())->format('Ymd'),
            'user' => $this->userRepository->getUserInfo($attempt->getUser()),
            'test' => $this->testRepository->getTestInfo($attempt->getTest()),
        ];

        $signature = md5(json_encode($result));
        $link = self::ATTEMPT_HOST.'/cashier/'.$result['attempt_id'].'/'.$signature;

        $attempt->setLink($link);
        $this->attemptRepository->store($attempt);

        $result['link'] = $link;

        return $result;
    }
    
    /**
     * 
     * @param int $attemptId
     * @param int $currentStage
     * @param string $token
     * @param array $answers
     * @return array
     * @throws Exception
     */
    public function stages(int $attemptId, int $currentStage, string $token, array $answers = []): array
    {
        /** @var Attempt $attempt */
        $attempt = $this->attemptRepository->find($attemptId);
        if (!($attempt instanceof Attempt)) {
            throw new Exception('Попытка с таким ID НЕ была зарегистрирована HR-менеджером!', 1);
        }
        if ($currentStage === 2) {
            $nextStageId = $this->increaseStage($attemptId, $currentStage, $token);
            $questions = $attempt->getTest()->getQuestions()->toArray();

            shuffle($questions);

            $questionsWithVariantsList = [
                'next_stage_id' => $nextStageId,
                'max_time' => $attempt->getTest()->getMaxTime(),
                'test' => $attempt->getTest()->getName(),
                'questions' => [],
            ];
            /**
             * @var int $i
             * @var Question $question
             */
            foreach ($questions as $i => $question) {
                $rvq = $this->getRightVariantsQuantity($question);
                $questionsWithVariantsList['questions'][$i] = [
                    'question_id' => $question->getId(),
                    'question' => $question->getText(),
                    'question_type' => $question->getType(),
                    'value' => ($rvq > 1) ? [] : '',
                    'field_type' => ($rvq > 1) ? 1 : 0,
                    'variants' => [],
                ];
                foreach ($question->getVariants() as $variant) {
                    $questionsWithVariantsList['questions'][$i]['variants'][$variant->getId()] = $variant->getText();
                }
            }

            // change start_timestamp after question list sending
            $attempt->setStartTimestamp((int) (new DateTime())->format('U'));
            $this->attemptRepository->store($attempt);

            return $questionsWithVariantsList;
        }
        if ($currentStage === 3) {
            $nextStageId = $this->increaseStage($attemptId, $currentStage, $token);
            if (empty($answers)) {
                $timeSpent = $attempt->getEndTimestamp() - $attempt->getStartTimestamp();
                return [
                    'next_stage_id' => $nextStageId,
                    'points_quantity' => $attempt->getNumberOfPoints(),
                    'time_spent' => $timeSpent,
                    'max_possible_time_spent' => $attempt->getTest()->getMaxTime(),
                    'deadline_is_out' => ($timeSpent > $attempt->getTest()->getMaxTime()),
                ];
            }
            $questions = $attempt->getTest()->getQuestions();
            $answeredQuestions = $answers['questions'];
            $pointsQuantity = [];
            foreach ($questions as $i => $question) {
                // calculate quantity of points
                $cost = 1 / $this->getRightVariantsQuantity($question);
                $pointsQuantity[$question->getId()] = 0;
                foreach ($answeredQuestions as $answeredQuestion) {
                    if ($answeredQuestion['question_id'] == $question->getId()) {
                        foreach ($question->getVariants() as $variant) {
                            if (is_array($answeredQuestion['value'])) {
                                foreach ($answeredQuestion['value'] as $usersAnswer) {
                                    if ($usersAnswer == $variant->getText()) {
                                        $this->prepareAnswerEntity($attempt, $variant);
                                        if ($variant->getValue() > 0) {
                                            $pointsQuantity[$question->getId()] += $cost;
                                        }
                                    }
                                }
                            } else {
                                if ($answeredQuestion['value'] == $variant->getText()) {
                                    $this->prepareAnswerEntity($attempt, $variant);
                                    if ($variant->getValue() > 0) {
                                        $pointsQuantity[$question->getId()] += $cost;
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $totalPointsQuantity = array_sum($pointsQuantity);

            // change end timestamp after questions list submitting
            $attempt->setEndTimestamp((int) (new DateTime())->format('U'));
            $this->attemptRepository->store($attempt);

            $timeSpent = $attempt->getEndTimestamp() - $attempt->getStartTimestamp();
            $totalPointsQuantity = ($timeSpent > $attempt->getTest()->getMaxTime()) ? 0 : $totalPointsQuantity;
            $attempt->setNumberOfPoints($totalPointsQuantity);
            $this->attemptRepository->store($attempt);
            return [
                'next_stage_id' => $nextStageId,
                'points_quantity' => $attempt->getNumberOfPoints(),
                'time_spent' => $timeSpent,
                'max_possible_time_spent' => $attempt->getTest()->getMaxTime(),
                'deadline_is_out' => ($timeSpent > $attempt->getTest()->getMaxTime()),
            ];
        }
        
        return [
            'next_stage_id' => $this->increaseStage($attemptId, $currentStage, $token),
        ];
    }

    /**
     * 
     * @param int $attemptId
     * @param int $currentStage
     * @return int
     * @throws Exception
     */
    private function increaseStage(int $attemptId, int $currentStage, string $token): int
    {
        /** @var Attempt $attempt */
        $attempt = $this->attemptRepository->find($attemptId);
        
        $tokenClauses = [
            'attempt_id' => $attempt->getId(),
            'current_date' => (new DateTime())->format('Ymd'),
            'user' => $this->userRepository->getUserInfo($attempt->getUser()),
            'test' => $this->testRepository->getTestInfo($attempt->getTest()),
        ];
        $latestToken = md5(json_encode($tokenClauses));
        
        if (empty($token)) {
            throw new Exception('Запрос НЕ подписан! Вы не можете перейти к сдаче теста или на следующий его этап.', 2);
        }
        if ($token !== $latestToken) {
            throw new Exception('Вам больше НЕ разрешено предпринимать попытку сдать этот тест! Возможно, срок уже вышел!', 2);
        }
        if (!($attempt instanceof Attempt)) {
            throw new Exception('Попытка с таким ID НЕ была зарегистрирована HR-менеджером!', 1);
        }
        if ($currentStage < 1 || $currentStage > 3) {
            throw new Exception('Неверный номер шага теста', 6);
        }
        if ($attempt->getStage() === 0 && $currentStage !== 3) {
            throw new Exception('Данный тест уже пройден. Ваш результат: '.$attempt->getNumberOfPoints().' Невозможно пройти тест еще раз!', 2);
        }
        if (($attempt->getStage() - $currentStage) > 1) {
            throw new Exception('Данный этап теста уже пройден. Невозможно пройти его ещё раз!', 2);
        }
        if (($currentStage - $attempt->getStage()) >= 1 && !($attempt->getStage() === 0 && $currentStage === 3)) {
            throw new Exception('Данный этап теста еще НЕ пройден. Невозможно пройти его, минуя предыдущий этап!', 2);
        }
        $attempt->setStage(($currentStage < 3) ? $currentStage + 1 : 0);
        $this->attemptRepository->store($attempt);

        return $attempt->getStage();
    }
    
    /**
     * 
     * @param Question $question
     * @return int
     */
    private function getRightVariantsQuantity(Question $question): int
    {
        $rvq = 0;
        foreach ($question->getVariants() as $variant) {
            $rvq += ($variant->getValue() > 0) ? 1 : 0;
        }

        return $rvq;
    }

    /**
     * @param Attempt $attempt
     * @param Variant $variant
     * @return Answer
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function prepareAnswerEntity(Attempt $attempt, Variant $variant): Answer
    {
        $answer = new Answer();
        $answer->setAttempt($attempt);
        $answer->setVariantId($variant->getId());
        $answer->setValue($variant->getValue());
        $this->answerRepository->store($answer);
        $attempt->addAnswer($answer);

        return $answer;
    }
}
