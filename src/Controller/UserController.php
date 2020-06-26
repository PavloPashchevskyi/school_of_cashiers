<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\Custom\MainController;
use App\Services\UserService;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Exception;

class UserController extends MainController
{
    /** @var UserService */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @Route("/api/user/add", methods={"POST"})
     * @SWG\Parameter(name="name", in="body", required=true, description="User's name", @SWG\Schema(type="string", maxLength=30))
     * @SWG\Parameter(name="city", in="body", required=true, description="User's city", @SWG\Schema(type="string", maxLength=30))
     * @SWG\Parameter(name="email", in="body", required=false, description="User's e-mail", @SWG\Schema(type="string", maxLength=180))
     * @SWG\Parameter(name="phone", in="body", required=true, description="User's phone", @SWG\Schema(type="string", maxLength=15))
     *
     * @SWG\Response(
     *     response="200",
     *     description="Returns success/failure of User adding",
     *     @SWG\Parameter(name="code", type="integer", description="Code of API response (if 0, than OK)", @SWG\Schema(type="integer")),
     *     @SWG\Parameter(name="message", type="string", description="Description of response", @SWG\Schema(type="string")),
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        if (!$this->isAdminAuthenticated()) {
            return $this->json([
                'code' => 3,
                'message' => 'Admin is NOT authenticated or time of session is up!',
            ], JsonResponse::HTTP_UNAUTHORIZED);
        }
        try {
            $data = $request->request->all();
            $this->userService->store($data);
            return $this->json([
                'code' => 0,
                'message' => 'OK',
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
