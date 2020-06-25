<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Services\AdminService;
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
     * @Route("/api/hr/login", methods={"POST"})
     * @SWG\Parameter(name="email", in="body", required=true, description="HR`s E-mail to log in", @SWG\Schema(type="string", maxLength=180))
     * @SWG\Parameter(name="password", in="body", type="string", required=true, description="HR`s password", @SWG\Schema(type="string"))
     *
     * @SWG\Response(
     *     response="200",
     *     description="HR has been logged in successfully",
     *     @SWG\Parameter(name="code", type="integer", description="Code of API response (if 0, than OK)", @SWG\Schema(type="integer")),
     *     @SWG\Parameter(name="message", type="string", description="Description of response", @SWG\Schema(type="string")),
     *     @SWG\Parameter(name="apiToken", type="string", description="API token to store into HTTP header", @SWG\Schema(type="string"))
     * )
     * @SWG\Response(
     *     response="401",
     *     description="incorrect authentication data",
     *     @SWG\Parameter(name="code", type="integer", description="Code of an error (if NOT 0, than error occured)", @SWG\Schema(type="string")),
     *     @SWG\Parameter(name="message", type="string", description="Description of an error", @SWG\Schema(type="string"))
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $authenticationData = file_get_contents('php://input');
        $authenticationData = json_decode($authenticationData, true);

        try {
            $authenticationResult = $this->adminService->authenticate($authenticationData);
            if (empty($authenticationResult)) {
                return $this->json([
                    'code' => 2,
                    'message' => 'Authentication data is NOT correct!',
                ], JsonResponse::HTTP_UNAUTHORIZED);
            }
            $session = $this->get('session');
            $session->set('hr_id', $authenticationResult['hr_id']);
            return $this->json([
                'code' => 0,
                'message' => 'OK',
                'hr_id' => $session->get('hr_id'),
            ]);
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

    public function adminDashboard()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
    }
}
