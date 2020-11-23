<?php
declare(strict_types=1);

namespace App\Services;

use App\Repository\TestRepository;
use App\Entity\Test;
use Exception;
use App\Entity\Question;

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


    public function questions(string $testType): array
    {
        $test = $this->testRepository->findOneBy(['type' => $testType]);
        
        if (!($test instanceof Test)) {
            throw new Exception('Тест такого типа НЕ найден', 1);
        }
        
        $commonTestData = $this->testRepository->getTestInfo($test);
        $commonTestData['questions'] = [];
        /** @var Question $question */
        foreach ($test->getQuestions() as $i => $question) {
            $rvq = $this->getRightVariantsQuantity($question);
            $commonTestData['questions'][$i] = [
                'question_id' => $question->getId(),
                'text' => $question->getText(),
                'field_type' => ($question->getType() === 2) ? 2 : (($rvq > 1) ? 1 : 0),
                'value' => ($rvq > 1 || $question->getType() === 2) ? [] : '',
                'error' => null,
                'variants' => [],
            ];
            
            $shuffledVariands = [];
            /** @var \App\Entity\Variant $variant */
            foreach ($question->getVariants() as $variant) {
                $shuffledVariands[] = [
                    'variant_id' => $variant->getId(),
                    'variant_text' => $variant->getText(),
                ];
            }
            
            shuffle($shuffledVariands);
            foreach ($shuffledVariands as $variant) {
                $commonTestData['questions'][$i]['variants'][$variant['variant_id']] = $variant['variant_text'];
            }    
        }
        
        shuffle($commonTestData['questions']);
        
        return $commonTestData;
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
}
