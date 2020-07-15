<?php
declare(strict_types=1);

namespace App\Services;

use App\Entity\Variant;
use App\Repository\AnswerRepository;
use App\Repository\AttemptRepository;
use App\Repository\UserRepository;
use App\Repository\TestRepository;
use App\Entity\Attempt;
use DateTime;
use App\Entity\Question;
use Exception;
use App\Entity\Answer;

class AnswerService
{
    /** @var AttemptRepository */
    private $attemptRepository;

    /** @var UserRepository */
    private $userRepository;

    /** @var TestRepository */
    private $testRepository;

    /** @var AnswerRepository */
    private $answerRepository;

    public function __construct(
        AttemptRepository $attemptRepository,
        UserRepository $userRepository,
        TestRepository $testRepository,
        AnswerRepository $answerRepository
    ) {
        $this->attemptRepository = $attemptRepository;
        $this->userRepository = $userRepository;
        $this->testRepository = $testRepository;
        $this->answerRepository = $answerRepository;
    }

    /**
     * @param int $attemptId
     * @param string $signature
     * @return array
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function getQuestionsList(int $attemptId, string $signature): array
    {
        /** @var Attempt $attempt */
        $attempt = $this->attemptRepository->find($attemptId);
        if (!($attempt instanceof Attempt)) {
            throw new Exception('Попытка с таким ID НЕ была зарегистрирована HR-менеджером!', 1);
        }
        $dataToCheck = [
            'attempt_id' => $attemptId,
            'current_date' => (new DateTime())->format('Ymd'),
            'user' => $this->userRepository->getUserInfo($attempt->getUser()),
            'test' => $this->testRepository->getTestInfo($attempt->getTest()),
        ];

        $signatureToCheck = md5(json_encode($dataToCheck));

        if ($signature !== $signatureToCheck) {
            throw new Exception('Вам больше НЕ разрешено предпринимать попытку сдать этот тест! Возможно, срок уже вышел!', 2);
        }

        $questions = $attempt->getTest()->getQuestions()->toArray();

        shuffle($questions);

        $questionsWithVariantsList = [
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

    /**
     * @param int $attemptId
     * @param array $answers
     * @return array
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function getAnswersFromUser(int $attemptId, array $answers): array
    {
        /** @var Attempt $attempt */
        $attempt = $this->attemptRepository->find($attemptId);
        if (!($attempt instanceof Attempt)) {
            throw new Exception('Попытка с таким ID НЕ была зарегистрирована HR-менеджером!', 1);
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
        $attempt->setNumberOfPoints($totalPointsQuantity);

        // change end timestamp after questions list submitting
        $attempt->setEndTimestamp((int) (new DateTime())->format('U'));
        $this->attemptRepository->store($attempt);

        $timeSpent = $attempt->getEndTimestamp() - $attempt->getStartTimestamp();
        return [
            'points_quantity' => $totalPointsQuantity,
            'time_spent' => $timeSpent,
            'max_possible_time_spent' => $attempt->getTest()->getMaxTime(),
            'deadline_is_out' => ($timeSpent > $attempt->getTest()->getMaxTime()),
        ];
    }

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
