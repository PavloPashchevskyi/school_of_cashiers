<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\Custom\MainController;
use App\Services\AttemptService;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;
use Exception;
use Symfony\Component\HttpFoundation\Request;

class AttemptController extends MainController
{
    /** @var AttemptService */
    private $attemptService;

    public function __construct(AttemptService $attemptService)
    {
        $this->attemptService = $attemptService;
    }

    /**
     * @Route("/api/attempts", methods={"GET"})
     *
     * @SWG\Response(
     *     response="200",
     *     description="Returns list of users attempts",
     *     @SWG\Parameter(name="code", type="integer", description="Code of API response (if 0, than OK)", @SWG\Schema(type="integer")),
     *     @SWG\Parameter(name="message", type="string", description="Description of response", @SWG\Schema(type="string")),
     *     @SWG\Parameter(name="data", type="array", description="Lisr of attempts", @SWG\Schema(type="array"))
     * )
     * @SWG\Response(
     *     response="401",
     *     description="Admin is NOT authenticated or time of session is up!",
     *     @SWG\Parameter(name="code", type="integer", description="Code of an error (if NOT 0, than error occured)", @SWG\Schema(type="integer")),
     *     @SWG\Parameter(name="message", type="string", description="Description of an error", @SWG\Schema(type="string"))
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
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        if (!$this->isAdminAuthenticated()) {
            return $this->json([
                'code' => 3,
                'message' => 'HR-менеджер НЕ авторизован или время сеанса истекло!',
            ], JsonResponse::HTTP_UNAUTHORIZED);
        }
        try {
            $attempts = $this->attemptService->getUsersAttempts();
            return $this->json([
                'code' => 0,
                'message' => 'OK',
                'data' => $attempts,
            ], JsonResponse::HTTP_OK);
        } catch (Exception $exc) {
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

    /**
     * @Route("/api/{userId}/{testId}/attempt/prepare", methods={"POST"})
     * @SWG\Parameter(name="userId", in="path", required=true, type="integer", description="User's ID")
     * @SWG\Parameter(name="testId", in="path", required=true, type="integer", description="ID of test")
     *
     * @SWG\Response(
     *     response="200",
     *     description="Returns success/failure of Attempt adding",
     *     @SWG\Parameter(name="code", type="integer", description="Code of API response (if 0, than OK)", @SWG\Schema(type="integer")),
     *     @SWG\Parameter(name="message", type="string", description="Description of response", @SWG\Schema(type="string")),
     *     @SWG\Parameter(name="data", type="array", description="Data returned after insertion preparition", @SWG\Schema(type="array"))
     * )
     * @SWG\Response(
     *     response="401",
     *     description="incorrect authentication data",
     *     @SWG\Parameter(name="code", type="integer", description="Code of an error (if NOT 0, than error occured)", @SWG\Schema(type="integer")),
     *     @SWG\Parameter(name="message", type="string", description="Description of an error", @SWG\Schema(type="string"))
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
    public function prepare(Request $request): JsonResponse
    {
        if (!$this->isAdminAuthenticated()) {
            return $this->json([
                'code' => 3,
                'message' => 'HR-менеджер НЕ авторизован или время сеанса истекло!',
            ], JsonResponse::HTTP_UNAUTHORIZED);
        }
        try {
            $dataToFindBy = $request->attributes->all();
            $prepared = $this->attemptService->prepare($dataToFindBy);
            return $this->json([
                'code' => 0,
                'message' => 'OK',
                'data' => $prepared,
            ], JsonResponse::HTTP_OK);
        } catch (Exception $exc) {
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
