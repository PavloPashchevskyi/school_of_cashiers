<?php
declare(strict_types=1);

namespace App\Services;

use App\Repository\UserRepository;
use App\Repository\TestRepository;
use App\Repository\AttemptRepository;
use App\Repository\AnswerRepository;
use App\Repository\VariantRepository;
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
    
    /** @var VariantRepository */
    private $variantRepository;

    public function __construct(
        UserRepository $userRepository,
        TestRepository $testRepository,
        AttemptRepository $attemptRepository,
        AnswerRepository $answerRepository,
        VariantRepository $variantRepository
    ) {
        $this->userRepository = $userRepository;
        $this->testRepository = $testRepository;
        $this->attemptRepository = $attemptRepository;
        $this->answerRepository = $answerRepository;
        $this->variantRepository = $variantRepository;
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
    
    public function getUserAttemptsDetails(int $userId): array
    {
        /** @var User $user */
        $user = $this->userRepository->find($userId);

        if (!($user instanceof User)) {
            throw new Exception('Пользователь с таким ID НЕ найден!', 1);
        }

        $userProfile = $user->getProfile();
        $results = [
            'user_name' => $user->getName(),
            'user_materials' => $userProfile['allMaterials'],
            'user_tests' => $userProfile['allTests'],
            'remaining_attempts_count' => [],
            'attempts' => [],
        ];
        
        $tests = $this->testRepository->findAll();
        /** @var Test $test */
        foreach ($tests as $test) {
            $testType = $test->getType();
            $results['remaining_attempts_count'][$testType] = $userProfile[$testType.'Attempts'];
        }

        /** @var Attempt[] $attempts */
        $attempts = $user->getAttempts();
        foreach ($attempts as $i => $attempt) {
            $quizResults = $this->calculateWonAndLosedQuestions($attempt);
            $results['attempts'][$i] = [
                'attempt_id' => $attempt->getId(),
                'test' => $attempt->getTest()->getName(),
                'right_answers_quantity' => $quizResults['won'],
                'wrong_answers_quantity' => $quizResults['losed'],
                'right_answers_percentage' => $quizResults['won_percentage'],
                'wrong_answers_percentage' => $quizResults['losed_percentage'],
                'points_quantity' => $attempt->getNumberOfPoints(),
                'status' => ($attempt->getNumberOfPoints() >= 74),
                'questions_quantity' => $quizResults['questions_quantity'],
                'start_timestamp' => $attempt->getStartTimestamp(),
                'end_timestamp' => $attempt->getEndTimestamp(),
            ];
        }
        
        return $results;
    }
    
    /**
     * 
     * @param array $answers
     * @return array
     * @throws Exception
     */
    public function calculateUserResultsAndRegisterAttempt(array $answers): array
    {
        $guest = $this->userRepository->find($answers['guest_id']);
        if (!($guest instanceof User)) {
            throw new Exception('Пользователь с таким ID НЕ найден!', 1);
        }
        $testData = $answers['data'];
        $test = $this->testRepository->findOneBy(['type' => $testData['type']]);
        if (!($test instanceof Test)) {
            throw new Exception('Тест с таким ID НЕ найден', 1);
        }
        
        $guestData = $guest->getProfile();
        $attemptsQuantityKey = $test->getType().'Attempts';
        if ($guestData[$attemptsQuantityKey] <= 0) {
            throw new Exception('Вам больше НЕ разрешено предпринимать попытку сдать этот тест! Количество попыток исчерпано!', 2);
        }
        $attempt = new Attempt();
        $attempt->setUser($guest);
        $attempt->setTest($test);
        $attempt->setStartTimestamp((int) $testData['test_start_timestamp']);
        
        $this->attemptRepository->preSave($attempt);
        
        foreach ($answers['data']['questions'] as $answerOfUser) {
            $questionVariants = [];
            foreach ($answerOfUser['variants'] as $aouv) {
                $questionVariants[$aouv['variant_id']] = $aouv['variant_text'];
            }
            if ($answerOfUser['field_type'] < 2) {
                $userVariantIds = (!is_array($answerOfUser['value'])) ?
                    array_keys($questionVariants, $answerOfUser['value']) :
                    array_keys(array_intersect($questionVariants, $answerOfUser['value']));
                foreach ($userVariantIds as $userVariantId) {
                    $userVariant = $this->variantRepository->find($userVariantId);
                    $this->prepareAnswerEntity($attempt, $userVariant);
                }
            } else {
                // parse user allocation of values
                $userAllocationValues = explode('|', $answerOfUser['value']);
                $userAllocationValues = array_map(function ($uaValue) {
                    return trim($uaValue);
                }, $userAllocationValues);
                // search for variants IDs
                $userVariantIds = [];
                foreach ($userAllocationValues as $i => $userAllocationValue) {
                    $userVariantIds[$i + 1] = array_search($userAllocationValue, $questionVariants);
                }
                foreach ($userVariantIds as $userVariantOrder => $userVariantId) { 
                    $userVariant = $this->variantRepository->find($userVariantId);
                    $answer = new Answer();
                    $answer->setAttempt($attempt);
                    $answer->setVariantId($userVariant->getId());
                    $answer->setValue($userVariantOrder);
                    $this->answerRepository->preSave($answer);
                    $attempt->addAnswer($answer);
                }
                $this->answerRepository->save();
                $this->attemptRepository->preSave($attempt);
            }
        }

        $results = $this->calculateWonAndLosedQuestions($attempt);
        $startTimestamp = $testData['test_start_timestamp'];
        $endTimestamp = (int) (new DateTime())->format('U');
        $execTimestamp = $endTimestamp - $startTimestamp;
        $results['won_percentage'] = ($execTimestamp > $test->getMaxTime()) ? 0 : $results['won_percentage'];
        $attempt->setEndTimestamp($endTimestamp);
        $attempt->setNumberOfPoints($results['won_percentage']);
        
        $this->attemptRepository->save();
        
        $results['status'] = ($results['won_percentage'] >= 74);
        $results['start_timestamp'] = $startTimestamp;
        $results['end_timestamp'] = $endTimestamp;
        
        // decrease attempts quantity to pass Test for Guest
        $guestData[$attemptsQuantityKey] = ($results['won_percentage'] >= 74) ?
                0 :
                ($guestData[$attemptsQuantityKey] - 1);
        $guest->setProfile($guestData);
        $this->userRepository->store($guest);

        return $results;
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
            return $this->getQuestionsList($attempt, $nextStageId);
        }
        if ($currentStage === 3) {
            $nextStageId = $this->increaseStage($attemptId, $currentStage, $token);
            return $this->calculateUserResults($attempt, $nextStageId, $answers);
        }
        
        return [
            'next_stage_id' => $this->increaseStage($attemptId, $currentStage, $token),
        ];
    }
    
    /**
     * 
     * @param Attempt $attempt
     * @return array
     */
    public function calculateWonAndLosedQuestions(Attempt $attempt)
    {
        $results = [
            'won' => 0,
            'losed' => 0,
        ];
        $rvq = [];
        $wvq = [];
        $questions = $attempt->getTest()->getQuestions();
        $answers = $attempt->getAnswers();

        /** @var Question $question */
        foreach ($questions as $question) {
            $rvq[$question->getId()] = 0;
            $wvq[$question->getId()] = 0;
            /** @var Variant $variant */
            foreach ($question->getVariants() as $variant) {
                /** @var Answer $answer */
                foreach ($answers as $answer) {
                    if ($answer->getVariantId() === $variant->getId()) {
                        if ($variant->getValue() > 0 && $variant->getValue() === $answer->getValue()) {
                            $rvq[$question->getId()]++;
                        } else {
                            $wvq[$question->getId()]++;
                        }
                    }
                }
            }
        }
        
        foreach ($questions as $question) {
            if (
                    $rvq[$question->getId()] > 0 && // if question is present in user`s right variants
                    $wvq[$question->getId()] === 0 && // ...and it is absent in wrong variants
                    $rvq[$question->getId()] === $this->getRightVariantsQuantity($question) // ...and all right variants are present in user`s answer
                ) {
                $results['won']++;
            } else {
                $results['losed']++; 
            }
        }

        $results['questions_quantity'] = $questions->count();
        $results['won_percentage'] = ($results['won'] / $questions->count()) * 100;
        $results['losed_percentage'] = ($results['losed'] / $questions->count()) * 100;
        
        return $results;
    }
    
    /**
     * 
     * @param int $userId
     * @param string $testName
     * @return array
     * @throws Exception
     */
    public function getUserAttemptsByTestName(int $userId, string $testName): array
    {
        $user = $this->userRepository->find($userId);
        $test = $this->testRepository->findOneBy(['name' => $testName]);

        if (!($user instanceof User)) {
            throw new Exception('Пользователь с таким ID НЕ найден!', 1);
        }
        if (!($test instanceof Test)) {
            throw new Exception('Тест с таким названием НЕ найден', 1);
        }
        
        /** @var Attempt[] $attempts */
        $attempts = $this->attemptRepository->findBy(['user' => $user, 'test' => $test,]);
        $userProfile = $user->getProfile();
        $remainingAQKey = $test->getType().'Attempts';
        $remainingAttemptsQuantity = (int) $userProfile[$remainingAQKey];
        $result = [
            'remaining_attempts_quantity' => $remainingAttemptsQuantity,
            'questions' => [],
        ];
        if (empty($attempts)) {
            $questionsList = $test->getQuestions();
            $result['test_name'] = $test->getName();
            foreach ($questionsList as $i => $question) {
                $result['questions'][$i] = [
                    'id' => $question->getId(),
                    'text' => $question->getText(),
                    'variants' => [],
                ];
                /** @var Variant $variant */
                foreach ($question->getVariants() as $variant) {
                    $result['questions'][$i]['variants'][$variant->getId()] = $variant->getText();
                }
            }
            return $result;
        }
        foreach ($attempts as $attempt) {
            /** @var Question[] $questionsList */
            $questionsList = $attempt->getTest()->getQuestions();
            $result['test_name'] = $attempt->getTest()->getName();
            foreach ($questionsList as $i => $question) {
                $result['questions'][$i] = [
                    'id' => $question->getId(),
                    'text' => $question->getText(),
                    'variants' => [],
                ];
                /** @var Variant $variant */
                foreach ($question->getVariants() as $variant) {
                    $result['questions'][$i]['variants'][$variant->getId()] = $variant->getText();
                }
            }
        }
        
        return $result;
    }
    
    public function calculateAttemptResultDetails(int $attemptId): array
    {
        $attempt = $this->attemptRepository->find($attemptId);
        if (!($attempt instanceof Attempt)) {
            throw new Exception('Попытка пользователя с таким ID НЕ найдена!', 1);
        }
        
        $questions = $attempt->getTest()->getQuestions();
        $detailedUserResultAttempt = ['questions' => [],];
        /** @var Question $question */
        foreach ($questions as $i => $question) {
            $questionAnswersInAttempt = $this->getQuestionAnswersInAttempt($attempt, $question);
            $detailedUserResultAttempt['questions'][$i] = [
                'text' => $question->getText(),
                'user_answer' => $questionAnswersInAttempt['user_answer'],
                'answers_list' => $questionAnswersInAttempt['answers_list'],
                'answer_status' => $questionAnswersInAttempt['answer_status'],
                'right_answers_list' => $questionAnswersInAttempt['right_answers_list'],
            ];
        }
        
        return $detailedUserResultAttempt;
    }
    
    private function getQuestionAnswersInAttempt(Attempt $attempt, Question $question): array
    {
        $questionVariants = $question->getVariants();
        $questionAnswersInAttempt = [];
        /** @var Variant $questionVariant */
        foreach ($questionVariants as $questionVariant) {
            $questionAnswersInAttempt['answers_list'][] = [
                'question_variant_id' => $questionVariant->getId(),
                'question_variant_text' => $questionVariant->getText(),
                'question_variant_value' => $questionVariant->getValue(),
            ];
        }
        
        $userAnswers = $attempt->getAnswers();
        /** @var Answer $answer */
        foreach ($userAnswers as $answer) {
            $variantId = $answer->getVariantId();
            /** @var Variant $variant */
            $variant = $this->variantRepository->find($variantId);
            // two different instances of THE SAME question (use operator == only)
            if ($variant->getQuestion() == $question) {
                $questionAnswersInAttempt['user_answer'][] = [
                    'user_variant_id' => $variant->getId(),
                    'user_variant_text' => $variant->getText(),
                    'user_variant_value' => $variant->getValue(),
                ];
                $questionAnswersInAttempt['answer_status'] = $this->isMultivariantQuestionAnswerRight($attempt, $question);
                $questionAnswersInAttempt['right_answers_list'] = array_filter($questionAnswersInAttempt['answers_list'], function ($questionAnswerInAttempt) {
                    return $questionAnswerInAttempt['question_variant_value'] > 0;
                });
            }
        }
        
        return $questionAnswersInAttempt;
    }
    
    private function isMultivariantQuestionAnswerRight(Attempt $attempt, Question $question): bool
    {
        // answers for ALL questions in Test of User
        $answers = $attempt->getAnswers();
        
        $rightAnswersQuantity = 0;
        $wrongAnswersQuantity = 0;
        /** @var Answer $answer */
        foreach ($answers as $answer) {
            $userVariantId = $answer->getVariantId();
            /** @var Variant $userVariant */
            $userVariant = $this->variantRepository->find($userVariantId);
            if ($userVariant->getQuestion() == $question) {
                /** @var Variant $questionVariant */
                foreach ($question->getVariants() as $questionVariant) {
                    if ($questionVariant->getId() === $answer->getVariantId()) {
                        if ($questionVariant->getValue() > 0 && $questionVariant->getValue() === $answer->getValue()) {
                            $rightAnswersQuantity++;
                        } else {
                            $wrongAnswersQuantity++;
                        }
                    }
                }
            }
        }
        
        return ($rightAnswersQuantity === $this->getRightVariantsQuantity($question) && $wrongAnswersQuantity === 0);
    }
    
    private function getQuestionsList(Attempt $attempt, int $nextStageId): array
    {
        $questions = $attempt->getTest()->getQuestions()->toArray();

            shuffle($questions);

            $questionsWithVariantsList = [
                'next_stage_id' => $nextStageId,
                'max_time' => $attempt->getTest()->getMaxTime(),
                'test' => $attempt->getTest()->getName(),
                'questions' => [],
            ];

            /** @var Question $question */
            foreach ($questions as $i => $question) {
                $rvq = $this->getRightVariantsQuantity($question);
                $questionsWithVariantsList['questions'][$i] = [
                    'question_id' => $question->getId(),
                    'question' => $question->getText(),
                    'question_type' => $question->getType(),
                    'value' => ($rvq > 1 || $question->getType() === 2) ? [] : '',
                    'field_type' => ($question->getType() === 2) ? 2 : (($rvq > 1) ? 1 : 0),
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

    private function calculateUserResults(Attempt $attempt, int $nextStageId, array $answers): array
    {
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
