<?php
declare(strict_types=1);

namespace App\Security;

use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use App\Entity\Admin;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\HttpFoundation\JsonResponse;

class TokenAuthenticator extends AbstractGuardAuthenticator
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Called on every request to decide if this authenticator should be
     * used for the request. Returning `false` will cause this authenticator
     * to be skipped.
     *
     * @param Request $request
     * @return bool
     */
    public function supports(Request $request)
    {
        // look for header "Authorization: Bearer <token>"
        return $request->headers->has('Authorization')
            && 0 === strpos($request->headers->get('Authorization'), 'Bearer ');
    }

    /**
     * Called on every request. Return whatever credentials you want to
     * be passed to getUser() as $credentials.
     *
     * @param Request $request
     * @return string|null
     */
    public function getCredentials(Request $request)
    {
        $authorizationHeader = $request->headers->get('Authorization');
        // skip beyond "Bearer "
        return substr($authorizationHeader, 7);
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $admin = $this->em->getRepository(Admin::class)->findOneBy([
            'api_token' => $credentials
        ]);
        if (!($admin instanceof Admin)) {
            throw new CustomUserMessageAuthenticationException('Invalid API Token');
        }
        return $admin;
    }

    public function checkCredentials($credentials, UserInterface $admin): bool
    {
        // Check credentials - e.g. make sure the password is valid.
        // In case of an API token, no credential check is needed.

        // Return `true` to cause authentication success
        dd('checking credentials');
        //return true;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // on success, let the request continue
        return ($token) ? 'Bearer: '.$token : '';
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): JsonResponse
    {
        return new JsonResponse([
            'message' => $exception->getMessageKey()
        ], JsonResponse::HTTP_UNAUTHORIZED);
    }

    /**
     * Called when authentication is needed, but it's not sent
     *
     * @param Request $request
     * @param AuthenticationException|null $authException
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
//        $data = [
//            // you might translate this message
//            'message' => 'Authentication Required'
//        ];
//
//        return new JsonResponse($data, JsonResponse::HTTP_UNAUTHORIZED);

        throw new \Exception('Not used: entry_point from other authentication is used');
    }

    public function supportsRememberMe()
    {
        return false;
    }
}
