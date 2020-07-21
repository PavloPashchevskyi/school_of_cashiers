<?php
declare(strict_types=1);

namespace App\Controller;

use App\Services\AdminService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Exception;

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
     * @Route("/api/login", methods={"POST"})
     * @SWG\Parameter(name="email", in="body", required=true, description="HR`s E-mail to log in", @SWG\Schema(type="string", maxLength=180))
     * @SWG\Parameter(name="password", in="body", type="string", required=true, description="HR`s password", @SWG\Schema(type="string"))
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
            $session = $this->get('session');
            $session->set('hr_id', $authenticationResult['hr_id']);
            return $this->json([
                'code' => 0,
                'message' => 'OK',
                'hr_id' => $session->get('hr_id'),
                'session_id' => $session->getId(),
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
     * @Route("/api/logout", methods={"GET"})
     *
     * @SWG\Response(
     *     response="200",
     *     description="HR has been logged out successfully",
     *     @SWG\Parameter(name="code", type="integer", description="Code of API response (if 0, than OK)", @SWG\Schema(type="integer")),
     *     @SWG\Parameter(name="message", type="string", description="Description of response", @SWG\Schema(type="string"))
     * )
     * @SWG\Response(
     *     response="500",
     *     description="An exception has been thrown and it is because of unable to log out the HR-manager",
     *     @SWG\Parameter(name="code", type="integer", description="Code of an error (if NOT 0, than error occured)", @SWG\Schema(type="integer")),
     *     @SWG\Parameter(name="message", type="string", description="Description of an error", @SWG\Schema(type="string"))
     * )
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $session = $this->get('session');
        $session->remove('hr_id');
        if ($session->has('hr_id')) {
            return $this->json([
                'code' => 4,
                'message' => 'Невозможно вывести из системы HR-менеджера с ID#'.$session->get('hr_id'),
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->json([
            'code' => 0,
            'message' => 'OK',
        ], JsonResponse::HTTP_OK);
    }
}
