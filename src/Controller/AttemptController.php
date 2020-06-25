<?php
declare(strict_types=1);

namespace App\Controller;

use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Services\AttemptService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Exception;

class AttemptController extends AbstractController
{
    /** @var AttemptService */
    private $attemptService;

    public function __construct(AttemptService $attemptService)
    {
        $this->attemptService = $attemptService;
    }

    /**
     * @Route("/api/{userId}/attempts", methods={"GET"})
     *
     * @SWG\Parameter(name="userId", in="path", type="integer", required=true, description="ID of User, which attemts we`re going to get", @SWG\Schema(type="integer"))
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
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
        if (!$this->isAdminAuthenticated()) {
            return $this->json([
                'code' => 3,
                'message' => 'Admin is NOT authenticated or time of session is up!',
            ], JsonResponse::HTTP_UNAUTHORIZED);
        }
        try {
            $userId = $request->attributes->getInt('userId');
            $attempts = $this->attemptService->getUserAttempts($userId);
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

    private function isAdminAuthenticated()
    {
        $session = $this->get('session');

        return $session->has('hr_id');
    }
}
