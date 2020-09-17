<?php
declare(strict_types=1);

namespace App\Services;

use App\Repository\TestRepository;
use App\Entity\Test;
use Exception;

/**
 * Description of TestService
 *
 * @author user
 */
class TestService
{
    /** @var TestRepository */
    private $testRepository;
    
    public function __construct(TestRepository $testRepository)
    {
        $this->testRepository = $testRepository;
    }


    public function questions(string $testName): array
    {
        $test = $this->testRepository->findOneBy(['name' => $testName]);
        
        if (!($test instanceof Test)) {
            throw new Exception('Тест с таким ID НЕ найден', 1);
        }
        
        $commonTestData = $this->testRepository->getTestInfo($test);
        $commonTestData['questions'] = [];
        /** @var \App\Entity\Question $question */
        foreach ($test->getQuestions() as $i => $question) {
            $commonTestData['questions'][$i] = [
                'question_id' => $question->getId(),
                'type' => $question->getType(),
                'text' => $question->getText(),
                'variants' => [],
            ];
            /** @var \App\Entity\Variant $variant */
            foreach ($question->getVariants() as $variant) {
                $commonTestData['questions'][$i]['variants'][$variant->getId()] = $variant->getText();
            }
        }
        
        shuffle($commonTestData['questions']);
        
        return $commonTestData;
    }
}
