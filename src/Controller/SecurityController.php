<?php
declare(strict_types=1);

namespace App\Controller;

use App\Services\AdminService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Throwable;

class SecurityController extends AbstractController
{
    /**
     * @var AdminService
     */
    private $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    /**
     * @Route("/api/login", methods={"POST", "OPTIONS"})
     * @SWG\Parameter(
     *     name="auth_details",
     *     in="body",
     *     required=true,
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(
     *             property="email",
     *             type="string",
     *             maxLength=180,
     *             description="HR`s E-mail"
     *         ),
     *         @SWG\Property(
     *             property="password",
     *             type="string",
     *             description="HR`s password"
     *         )
     *     )
     * )
     *
     * @SWG\Response(
     *     response="200",
     *     description="HR has been logged in successfully",
     *     @SWG\Parameter(name="code", type="integer", description="Code of API response (if 0, than OK)", @SWG\Schema(type="integer")),
     *     @SWG\Parameter(name="message", type="string", description="Description of response", @SWG\Schema(type="string")),
     *     @SWG\Parameter(name="hr_id", type="integer", description="ID of HR logged in", @SWG\Schema(type="integer")),
     *     @SWG\Parameter(name="session_id", type="string", description="ID of User`s session", @SWG\Schema(type="string"))
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
    public function login(Request $request): JsonResponse
    {
        try {
            $authenticationData = json_decode($request->getContent(), true);
            $authenticationResult = $this->adminService->authenticate($authenticationData);
            if (empty($authenticationResult)) {
                return $this->json([
                    'code' => 2,
                    'message' => 'Данные аутентификации НЕ верны!',
                ], JsonResponse::HTTP_UNAUTHORIZED);
            }
            return $this->json([
                'code' => 0,
                'message' => 'OK',
                'hr_id' => $authenticationResult['hr_id'],
                'token' => $authenticationResult['token'],
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
    
    /**
     * @Route("/api/auth/check", methods={"POST"})
     * @SWG\Parameter(
     *     name="auth_details",
     *     in="body",
     *     required=true,
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(
     *             property="hr_id",
     *             type="integer",
     *             description="ID of HR-manager supposedly logged in",
     *             example=1
     *         ),
     *         @SWG\Property(
     *             property="timestamp",
     *             type="integer",
     *             description="When request was sent",
     *             example=1147234007
     *         ),
     *         @SWG\Property(
     *             property="token",
     *             type="string",
     *             description="User`s API token"
     *         )
     *     )
     * )
     * 
     * @SWG\Response(
     *     response="200",
     *     description="HR is logged in",
     *     @SWG\Parameter(name="code", type="integer", description="Code of API response (if 0, than OK)", @SWG\Schema(type="integer")),
     *     @SWG\Parameter(name="message", type="string", description="Description of response", @SWG\Schema(type="string"))
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
    public function check(Request $request): JsonResponse
    {    
        try {
            $data = json_decode($request->getContent(), true);
            $authenticationData = $this->adminService->check($data);
            return $this->json([
                'code' => 0,
                'message' => 'OK',
                'hr_id' => $authenticationData['hr_id'],
                'token' => $authenticationData['token'],
            ], JsonResponse::HTTP_OK);
        } catch (Throwable $exc) {
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
                    ($exc->getCode() === 3) ?
                    JsonResponse::HTTP_UNAUTHORIZED :
                    (($exc->getCode() === 5) ?
                            JsonResponse::HTTP_REQUEST_TIMEOUT :
                            JsonResponse::HTTP_INTERNAL_SERVER_ERROR)
                );
        }
    }

    /**
     * @Route("/api/logout", methods={"POST"})
     * @SWG\Parameter(
     *     name="auth_details",
     *     in="body",
     *     required=true,
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(
     *             property="hr_id",
     *             type="integer",
     *             description="ID of HR-manager supposedly logged in",
     *             example=1
     *         ),
     *         @SWG\Property(
     *             property="timestamp",
     *             type="integer",
     *             description="When request was sent",
     *             example=1147234007
     *         ),
     *         @SWG\Property(
     *             property="token",
     *             type="string",
     *             description="User`s API token"
     *         )
     *     )
     * )
     *
     * @SWG\Response(
     *     response="200",
     *     description="HR has been logged out successfully",
     *     @SWG\Parameter(name="code", type="integer", description="Code of API response (if 0, than OK)", @SWG\Schema(type="integer")),
     *     @SWG\Parameter(name="message", type="string", description="Description of response", @SWG\Schema(type="string"))
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
    public function logout(Request $request): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);
            $this->adminService->check($data);
            $logoutResult = $this->adminService->logout($data);
            return $this->json($logoutResult, JsonResponse::HTTP_OK);
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
}
