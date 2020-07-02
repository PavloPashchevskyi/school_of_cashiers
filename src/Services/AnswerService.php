<?php
declare(strict_types=1);

namespace App\Services;

use App\Repository\AttemptRepository;
use App\Repository\TestRepository;
use App\Repository\UserRepository;
use Exception;
use App\Entity\Attempt;

class AnswerService
{
    /** @var AttemptRepository */
    private $attemptRepository;

    /** @var UserRepository */
    private $userRepository;

    /** @var TestRepository */
    private $testRepository;

    public function __construct(
        AttemptRepository $attemptRepository,
        UserRepository $userRepository,
        TestRepository $testRepository
    ) {
        $this->attemptRepository = $attemptRepository;
        $this->userRepository = $userRepository;
        $this->testRepository = $testRepository;
    }

    public function getQuestionsList(int $attemptId, string $signature): array
    {
        /** @var Attempt $attempt */
        $attempt = $this->attemptRepository->find($attemptId);
        if (!($attempt instanceof Attempt)) {
            throw new Exception('Attempt with this ID has not been registered by HR manager!', 1);
        }
        $dataToCheck = [
            'attempt_id' => $attemptId,
            'current_date' => (new \DateTime())->format('Ymd'),
            'user' => $this->userRepository->getUserInfo($attempt->getUser()),
            'test' => $this->testRepository->getTestInfo($attempt->getTest()),
        ];

        $signatureToCheck = md5(json_encode($dataToCheck));

        if ($signature !== $signatureToCheck) {
            throw new Exception('You do not have permission to attempt this test! Possibly, deadline is out!', 2);
        }

        $questions = $attempt->getTest()->getQuestions()->toArray();

        shuffle($questions);

        $questionsWithVariantsList = [
            'test' => $attempt->getTest()->getName(),
            'questions' => [],
        ];
        foreach ($questions as $i => $question) {
            $questionsWithVariantsList['questions'][$i] = [
                'question_id' => $question->getId(),
                'question' => $question->getText(),
                'question_type' => $question->getType(),
                'variants' => [],
            ];
            foreach ($question->getVariants() as $variant) {
                $questionsWithVariantsList['questions'][$i]['variants'][$variant->getId()] = $variant->getText();
            }
        }

        return $questionsWithVariantsList;
    }
}
