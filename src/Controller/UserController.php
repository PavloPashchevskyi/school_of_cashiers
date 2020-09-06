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
     * @SWG\Parameter(name="name", in="body", required=true, description="User's name", @SWG\Schema(type="string", maxLength=30))
     * @SWG\Parameter(name="city", in="body", required=true, description="User's city", @SWG\Schema(type="string", maxLength=30))
     * @SWG\Parameter(name="phone", in="body", required=true, description="User's phone", @SWG\Schema(type="string", maxLength=15))
     * @SWG\Parameter(name="hr_id", in="body", required=true, description="ID of HR-manager supposedly logged in", @SWG\Schema(type="integer"))
     * @SWG\Parameter(name="timestamp", in="body", required=true, description="When request was sent", @SWG\Schema(type="integer"))
     * @SWG\Parameter(name="token", in="body", required=true, description="User`s API token", @SWG\Schema(type="string"))
     *
     * @SWG\Response(
     *     response="200",
     *     description="Returns success/failure of User adding and ID of user added",
     *     @SWG\Parameter(name="code", type="integer", description="Code of API response (if 0, than OK)", @SWG\Schema(type="integer")),
     *     @SWG\Parameter(name="message", type="string", description="Description of response", @SWG\Schema(type="string")),
     *     @SWG\Parameter(name="data", type="array", description="Info about just-created User", @SWG\Schema(type="array")),
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
            $result = $this->userService->store($data);
            return $this->json([
                'code' => 0,
                'message' => 'OK',
                'data' => $result,
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
     * @Route("/api/guests", methods={"POST"})
     * @SWG\Parameter(name="hr_id", in="body", required=true, description="ID of HR-manager supposedly logged in", @SWG\Schema(type="integer"))
     * @SWG\Parameter(name="timestamp", in="body", required=true, description="When request was sent", @SWG\Schema(type="integer"))
     * @SWG\Parameter(name="token", in="body", required=true, description="User`s API token", @SWG\Schema(type="string"))
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
}
