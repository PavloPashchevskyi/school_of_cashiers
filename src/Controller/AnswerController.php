<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Services\AnswerService;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Exception;

class AnswerController extends AbstractController
{
    /** @var AnswerService */
    private $answerService;

    public function __construct(AnswerService $answerService)
    {
        $this->answerService = $answerService;
    }

    /**
     * @Route("/api/{attemptId}/questions", methods={"GET"})
     * @SWG\Parameter(name="attemptId", in="path", required=true, description="ID of User`s attempt to test", @SWG\Schema(type="integer"))
     * @SWG\Parameter(name="signature", in="query", required=true, description="User`s signature", @SWG\Schema(type="string"))
     *
     * @SWG\Response(
     *     response="200",
     *     description="Returns questions list of the Test",
     *     @SWG\Parameter(name="code", type="integer", description="Code of API response (if 0, than OK)", @SWG\Schema(type="integer")),
     *     @SWG\Parameter(name="message", type="string", description="Description of response", @SWG\Schema(type="string")),
     *     @SWG\Parameter(name="data", type="array", description="Questions list returned", @SWG\Schema(type="array"))
     * )
     * @SWG\Response(
     *     response="401",
     *     description="incorrect authentication data",
     *     @SWG\Parameter(name="code", type="integer", description="Code of an error (if NOT 0, than error occured)", @SWG\Schema(type="integer")),
     *     @SWG\Parameter(name="message", type="string", description="Description of an error", @SWG\Schema(type="string"))
     * )
     * @SWG\Response(
     *     response="403",
     *     description="Access denied (User is authorized, but deadline is out)",
     *     @SWG\Parameter(name="code", type="integer", description="Code of an error (if NOT 0, than error occured)", @SWG\Schema(type="integer")),
     *     @SWG\Parameter(name="message", type="string", description="Description of an error", @SWG\Schema(type="string"))
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function questionsList(Request $request): JsonResponse
    {
        try {
            $attemptId = $request->attributes->getInt('attemptId');
            $signature = $request->query->get('signature');
            $questionsList = $this->answerService->getQuestionsList($attemptId, $signature);
            return $this->json([
                'code' => 0,
                'message' => 'OK',
                'data' => $questionsList,
            ], JsonResponse::HTTP_OK);
        } catch (Exception $exc) {
            return $this->json(
                [
                'errors' => [
                    'server' => [
                        'code' => $exc->getCode(),
                        'message' => $exc->getMessage(),
                        'trace' => $exc->getTrace(),
                    ],
                ],
            ],
                ($exc->getCode() === 2) ?
                    JsonResponse::HTTP_FORBIDDEN :
                    (($exc->getCode() === 1 ) ?
                        JsonResponse::HTTP_UNAUTHORIZED :
                        JsonResponse::HTTP_INTERNAL_SERVER_ERROR)
            );
        }
    }
}
