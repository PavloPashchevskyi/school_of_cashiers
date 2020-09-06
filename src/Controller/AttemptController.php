<?php
declare(strict_types=1);

namespace App\Controller;

use App\Services\AdminService;
use App\Services\AttemptService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;
use Throwable;
use Symfony\Component\HttpFoundation\Request;

class AttemptController extends AbstractController
{
    /** @var AdminService */
    private $adminService;

    /** @var AttemptService */
    private $attemptService;

    public function __construct(AttemptService $attemptService, AdminService $adminService)
    {
        $this->attemptService = $attemptService;
        $this->adminService = $adminService;
    }

    /**
     * @Route("/api/attempts", methods={"POST"})
     * @SWG\Parameter(name="hr_id", in="body", required=true, description="ID of HR-manager supposedly logged in", @SWG\Schema(type="integer"))
     * @SWG\Parameter(name="timestamp", in="body", required=true, description="When request was sent", @SWG\Schema(type="integer"))
     * @SWG\Parameter(name="token", in="body", required=true, description="User`s API token", @SWG\Schema(type="string"))
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
     *     @SWG\Parameter(
     *         name="errors",
     *         type="array",
     *         description="Array, which only key is 'server' and it contains an array with code and message of thrown exception",
     *         @SWG\Schema(type="array")
     *     )
     * )
     * @SWG\Response(
     *     response="408",
     *     description="Request timed out",
     *     @SWG\Parameter(
     *         name="errors",
     *         type="array",
     *         description="Array, which only key is 'server' and it contains an array with code and message of thrown exception",
     *         @SWG\Schema(type="array")
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
    public function usersAttempts(Request $request): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);
            $this->adminService->check($data);
            $attempts = $this->attemptService->getUsersAttempts();
            return $this->json([
                'code' => 0,
                'message' => 'OK',
                'data' => $attempts,
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
            ], ($exc->getCode() == 5) ?
                JsonResponse::HTTP_REQUEST_TIMEOUT :
                (($exc->getCode() == 3) ?
                    JsonResponse::HTTP_UNAUTHORIZED :
                    JsonResponse::HTTP_INTERNAL_SERVER_ERROR)
            );
        }
    }
    
    /**
     * @Route("/api/attempts/{guestId}", methods={"POST"})
     * @SWG\Parameter(name="guestId", in="path", required=true, type="integer", description="ID of User, which attempts are needed of")
     * @SWG\Parameter(name="hr_id", in="body", required=true, description="ID of HR-manager supposedly logged in", @SWG\Schema(type="integer"))
     * @SWG\Parameter(name="timestamp", in="body", required=true, description="When request was sent", @SWG\Schema(type="integer"))
     * @SWG\Parameter(name="token", in="body", required=true, description="User`s API token", @SWG\Schema(type="string"))
     * 
     * @SWG\Response(
     *     response="200",
     *     description="Returns all Attempts list",
     *     @SWG\Parameter(name="code", type="integer", description="Code of API response (if 0, than OK)", @SWG\Schema(type="integer")),
     *     @SWG\Parameter(name="message", type="string", description="Description of response", @SWG\Schema(type="string")),
     *     @SWG\Parameter(name="data", type="array", description="List of all attempts", @SWG\Schema(type="array"))
     * )
     * @SWG\Response(
     *     response="401",
     *     description="incorrect authentication data",
     *     @SWG\Parameter(
     *         name="errors",
     *         type="array",
     *         description="Array, which only key is 'server' and it contains an array with code and message of thrown exception",
     *         @SWG\Schema(type="array")
     *     )
     * )
     * @SWG\Response(
     *     response="408",
     *     description="Request timed out",
     *     @SWG\Parameter(
     *         name="errors",
     *         type="array",
     *         description="Array, which only key is 'server' and it contains an array with code and message of thrown exception",
     *         @SWG\Schema(type="array")
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
    public function userAttempts(Request $request): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);
            $this->adminService->check($data);
            $attemptsList = $this->attemptService->getUserAttempts($request->attributes->getInt('guestId'));
            return $this->json([
                'code' => 0,
                'message' => 'OK',
                'data' => $attemptsList,
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
            ],
                ($exc->getCode() == 5) ?
                    JsonResponse::HTTP_REQUEST_TIMEOUT :
                    (($exc->getCode() == 3) ?
                        JsonResponse::HTTP_UNAUTHORIZED :
                        JsonResponse::HTTP_INTERNAL_SERVER_ERROR)
            );
        }
    }
    
    /**
     * @Route("/api/guest/details/{guestId}", methods={"POST"})
     * @SWG\Parameter(name="guestId", in="path", required=true, type="integer", description="User's ID")
     * @SWG\Parameter(name="hr_id", in="body", required=true, description="ID of HR-manager supposedly logged in", @SWG\Schema(type="integer"))
     * @SWG\Parameter(name="timestamp", in="body", required=true, description="When request was sent", @SWG\Schema(type="integer"))
     * @SWG\Parameter(name="token", in="body", required=true, description="User`s API token", @SWG\Schema(type="string"))
     * 
     * * @SWG\Response(
     *     response="200",
     *     description="Returns list of user`s attempts in details",
     *     @SWG\Parameter(name="code", type="integer", description="Code of API response (if 0, than OK)", @SWG\Schema(type="integer")),
     *     @SWG\Parameter(name="message", type="string", description="Description of response", @SWG\Schema(type="string")),
     *     @SWG\Parameter(name="data", type="array", description="Array of user`s attempts described in details", @SWG\Schema(type="array"))
     * )
     * @SWG\Response(
     *     response="400",
     *     description="Incorrect User ID in request",
     *     @SWG\Parameter(
     *         name="errors",
     *         type="array",
     *         description="Array, which only key is 'server' and it contains an array with code and message of thrown exception",
     *         @SWG\Schema(type="array")
     *     )
     * )
     * @SWG\Response(
     *     response="401",
     *     description="incorrect authentication data",
     *     @SWG\Parameter(
     *         name="errors",
     *         type="array",
     *         description="Array, which only key is 'server' and it contains an array with code and message of thrown exception",
     *         @SWG\Schema(type="array")
     *     )
     * )
     * @SWG\Response(
     *     response="408",
     *     description="Request timed out",
     *     @SWG\Parameter(
     *         name="errors",
     *         type="array",
     *         description="Array, which only key is 'server' and it contains an array with code and message of thrown exception",
     *         @SWG\Schema(type="array")
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
    public function detailedUserAttempts(Request $request): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);
            $this->adminService->check($data);
            $attemptsList = $this->attemptService->getUserAttemptsDetails($request->attributes->getInt('guestId'));
            return $this->json([
                'code' => 0,
                'message' => 'OK',
                'data' => $attemptsList,
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
            ],
                ($exc->getCode() == 5) ?
                    JsonResponse::HTTP_REQUEST_TIMEOUT :
                    (($exc->getCode() == 3) ?
                        JsonResponse::HTTP_UNAUTHORIZED :
                            (($exc->getCode() == 1) ?
                                JsonResponse::HTTP_BAD_REQUEST :
                                JsonResponse::HTTP_INTERNAL_SERVER_ERROR))
            );
        }
    }

    /**
     * @Route("/api/cashier/{attemptId}/{token}", methods={"POST"})
     * @SWG\Parameter(name="attemptId", in="path", required=true, type="integer", description="ID of User`s attempt to test", @SWG\Schema(type="integer"))
     * @SWG\Parameter(name="token", in="path", type="string", required=true, description="User`s API token", @SWG\Schema(type="string"))
     * @SWG\Parameter(name="current_stage_id", in="body", required=true, type="integer", description="User`s current stage", @SWG\Schema(type="integer"))
     * @SWG\Parameter(
     *     name="answers",
     *     in="body",
     *     required=false,
     *     description="Answers of User",
     *     @SWG\Schema(
     *         @SWG\Property(
     *             property="answers",
     *             type="array",
     *             @SWG\Items(
     *                 @SWG\Property(property="test", type="string"),
     *                 @SWG\Property(
     *                     property="questions",
     *                     type="array",
     *                     @SWG\Items(
     *                         @SWG\Property(property="question_id", type="integer"),
     *                         @SWG\Property(property="question", type="string"),
     *                         @SWG\Property(property="question_type", type="integer"),
     *                         @SWG\Property(property="variants", type="object"),
     *                         @SWG\Property(property="value", type="string")
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     * 
     * @SWG\Response(
     *     response="200",
     *     description="Returns ID of next stage",
     *     @SWG\Parameter(name="code", type="integer", description="Code of API response (if 0, than OK)", @SWG\Schema(type="integer")),
     *     @SWG\Parameter(name="message", type="string", description="Description of response", @SWG\Schema(type="string")),
     *     @SWG\Parameter(name="data", type="array", description="data returned after this stage", @SWG\Schema(type="array"))
     * )
     * @SWG\Response(
     *     response="400",
     *     description="Bad request (Incorrect current stage number)",
     *     @SWG\Parameter(
     *         name="errors",
     *         type="array",
     *         description="Array, which only key is 'server' and it contains an array with code and message of thrown exception",
     *         @SWG\Schema(type="array")
     *     )
     * )
     * @SWG\Response(
     *     response="401",
     *     description="incorrect authentication data",
     *     @SWG\Parameter(
     *         name="errors",
     *         type="array",
     *         description="Array, which only key is 'server' and it contains an array with code and message of thrown exception",
     *         @SWG\Schema(type="array")
     *     )
     * )
     * @SWG\Response(
     *     response="403",
     *     description="Access denied, because transferred stage of test has been already done",
     *     @SWG\Parameter(
     *         name="errors",
     *         type="array",
     *         description="Array, which only key is 'server' and it contains an array with code and message of thrown exception",
     *         @SWG\Schema(type="array")
     *     )
     * )
     * @SWG\Response(
     *     response="500",
     *     description="An exception has been thrown and it is NOT because of authorization data, deadlines or incorrect current stage number",
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
    public function stages(Request $request): JsonResponse
    {
        try {
            $attemptId = $request->attributes->getInt('attemptId');
            $token = $request->attributes->get('token');
            $requestData = json_decode($request->getContent(), true);
            $answers = !empty($requestData['answers']) ? $requestData['answers'][0] : [];
            $responseData = $this->attemptService->stages($attemptId, $requestData['current_stage_id'], $token, $answers);
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
            ], ($exc->getCode() === 1) ?
                    JsonResponse::HTTP_UNAUTHORIZED :
                    (($exc->getCode() === 6) ?
                            JsonResponse::HTTP_BAD_REQUEST :
                            (($exc->getCode() === 2) ?
                                    JsonResponse::HTTP_FORBIDDEN :
                                    JsonResponse::HTTP_INTERNAL_SERVER_ERROR))
            );
        }
    }
}
