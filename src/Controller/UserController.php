<?php
declare(strict_types=1);

namespace App\Controller;

use App\Services\AdminService;
use App\Services\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Throwable;

class UserController extends AbstractController
{
    /** @var AdminService */
    private $adminService;

    /** @var UserService */
    private $userService;

    public function __construct(UserService $userService, AdminService $adminService)
    {
        $this->adminService = $adminService;
        $this->userService = $userService;
    }

    /**
     * @Route("/api/guest/add", methods={"POST"})
     * @SWG\Parameter(
     *     name="auth_and_guest_details",
     *     in="body",
     *     required=true,
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(
     *             property="name",
     *             type="string",
     *             maxLength=80,
     *             description="User's name",
     *             example="Иванов Иван Иванович"
     *         ),
     *         @SWG\Property(
     *             property="city",
     *             type="string",
     *             maxLength=30,
     *             description="User's city",
     *             example="Киев"
     *         ),
     *         @SWG\Property(
     *             property="phone",
     *             type="string",
     *             maxLength=15,
     *             description="User's phone",
     *             example="+380441234544"
     *         ),
     *         @SWG\Property(
     *             property="guest_data",
     *             type="object"
     *         ),
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
     *     description="Returns success/failure of User adding and ID of user added",
     *     @SWG\Parameter(name="code", type="integer", description="Code of API response (if 0, than OK)", @SWG\Schema(type="integer")),
     *     @SWG\Parameter(name="message", type="string", description="Description of response", @SWG\Schema(type="string")),
     *     @SWG\Parameter(name="created_user_id", type="integer", description="ID of just-created User", @SWG\Schema(type="integer")),
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
    public function store(Request $request): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);
            $this->adminService->check($data);
            $newUserId = $this->userService->store($data);
            return $this->json([
                'code' => 0,
                'message' => 'OK',
                'created_user_id' => $newUserId,
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
     * @Route("/api/guest/login", methods={"POST"})
     * @SWG\Parameter(
     *     name="auth_details",
     *     in="body",
     *     required=true,
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(
     *             property="login",
     *             type="string",
     *             maxLength=255,
     *             description="Guest`s login"
     *         ),
     *         @SWG\Property(
     *             property="password",
     *             type="string",
     *             description="Guest`s password"
     *         )
     *     )
     * )
     *
     * @SWG\Response(
     *     response="200",
     *     description="Guest has been logged in successfully",
     *     @SWG\Parameter(name="code", type="integer", description="Code of API response (if 0, than OK)", @SWG\Schema(type="integer")),
     *     @SWG\Parameter(name="message", type="string", description="Description of response", @SWG\Schema(type="string")),
     *     @SWG\Parameter(name="guest_id", type="integer", description="ID of Guest logged in", @SWG\Schema(type="integer")),
     *     @SWG\Parameter(name="token", type="string", description="Guest`s token", @SWG\Schema(type="string"))
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
            $authenticationResult = $this->userService->authenticate($authenticationData);
            if (empty($authenticationResult)) {
                return $this->json([
                    'code' => 2,
                    'message' => 'Данные аутентификации НЕ верны!',
                ], JsonResponse::HTTP_UNAUTHORIZED);
            }
            return $this->json([
                'code' => 0,
                'message' => 'OK',
                'guest_id' => $authenticationResult['guest_id'],
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
     * @Route("/api/guest/auth/check", methods={"POST"})
     * @SWG\Parameter(
     *     name="auth_details",
     *     in="body",
     *     required=true,
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(
     *             property="guest_id",
     *             type="integer",
     *             description="ID of Guest supposedly logged in",
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
     *             description="Guest`s API token"
     *         )
     *     )
     * )
     * 
     * @SWG\Response(
     *     response="200",
     *     description="Guest is logged in",
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
            $authenticationData = $this->userService->check($data);
            return $this->json([
                'code' => 0,
                'message' => 'OK',
                'guest_id' => $authenticationData['guest_id'],
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
     * @Route("/api/guest/logout", methods={"POST"})
     * @SWG\Parameter(
     *     name="auth_details",
     *     in="body",
     *     required=true,
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(
     *             property="guest_id",
     *             type="integer",
     *             description="ID of Guest supposedly logged in",
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
     *             description="Guest`s API token"
     *         )
     *     )
     * )
     *
     * @SWG\Response(
     *     response="200",
     *     description="Guest has been logged out successfully",
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
            $this->userService->check($data);
            $logoutResult = $this->userService->logout($data);
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
    
    /**
     * @Route("/api/guests", methods={"POST"})
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
     *     description="Returns list of all Users, registered by HR-managers",
     *     @SWG\Parameter(name="code", type="integer", description="Code of API response (if 0, than OK)", @SWG\Schema(type="integer")),
     *     @SWG\Parameter(name="message", type="string", description="Description of response", @SWG\Schema(type="string")),
     *     @SWG\Parameter(name="data", type="array", description="Array of all Users, registered by HR-managers", @SWG\Schema(type="array"))
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
    public function list(Request $request): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);
            $this->adminService->check($data);
            $users = $this->userService->list();
            return $this->json([
                'code' => 0,
                'message' => 'OK',
                'data' => $users,
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
     * @Route("/api/guest/learningstatus/update", methods={"POST"})
     * @SWG\Parameter(
     *     name="auth_details",
     *     in="body",
     *     required=true,
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(
     *             property="guest_id",
     *             type="integer",
     *             description="ID of Guest supposedly logged in",
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
     *             description="Guest`s API token"
     *         ),
     *         @SWG\Property(
     *             property="guest_data",
     *             type="object"
     *         )
     *     )
     * )
     * 
     * @SWG\Response(
     *     response="200",
     *     description="Guest data have been updated successfully",
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
    public function updateLearningStatuses(Request $request): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);
            $this->userService->check($data);
            $this->userService->updateLearningStatuses($data);
            return $this->json([
                'code' => 0,
                'message' => 'OK',
            ]);
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
