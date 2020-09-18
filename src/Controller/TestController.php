<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Services\TestService;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Throwable;

/**
 * Description of TestController
 *
 * @author user
 */
class TestController extends AbstractController
{
    /** @var TestService */
    private $testService;
    
    public function __construct(TestService $testService)
    {
        $this->testService = $testService;
    }

    /**
     * @Route("/api/guest/test", methods={"POST"})
     * @SWG\Parameter(
     *     name="test_details",
     *     in="body",
     *     required=true,
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(
     *             property="type",
     *             type="string",
     *             description="Type of the Test",
     *             example="currency"
     *         )
     *     )
     * )
     * 
     * @SWG\Response(
     *     response="200",
     *     description="Returns list of questions from Test",
     *     @SWG\Parameter(
     *         in="body",
     *         required=true,
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(property="code", type="integer", description="Code of API response (if 0, than OK)"),
     *             @SWG\Property(property="message", type="string", description="Description of response"),
     *             @SWG\Property(property="data", type="object", description="Array of questions from the Test")
     *         )
     *     )
     * )
     * @SWG\Response(
     *     response="500",
     *     description="An exception has been thrown and it is NOT because of authorization data or deadlines",
     *     @SWG\Parameter(
     *         name="errors",
     *         type="array",
     *         description="Array, which only key is 'server' and it contains an array with code and message of thrown exception",
     *         @SWG\Schema(type="array")
     *     )
     * )
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function questions(Request $request): JsonResponse
    {
        try {
            $requestData = json_decode($request->getContent(), true);
            $responseData = $this->testService->questions($requestData['type']);
            return $this->json([
                'code' => 0,
                'message' => 'OK',
                'data' => $responseData,
            ], JsonResponse::HTTP_OK);
        } catch (Throwable $exc) {
            return $this->json([
                'errors' => [
                    'server' => [
                        'code' => $exc->getCode(),
                        'message' => $exc->getMessage(),
                        'trace' => $exc->getTrace(),
                    ],
                ],
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
