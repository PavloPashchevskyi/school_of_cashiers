<?php
declare(strict_types=1);

namespace App\Services;

use App\Repository\AdminRepository;
use App\Entity\Admin;
use App\Security\TokenAuthenticator;
use Exception;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminService
{
    /** @var AdminRepository */
    private $adminRepository;

    /** @var UserPasswordEncoderInterface */
    private $passwordEncoder;

    /** @var TokenAuthenticator */
    private $guardAuthenticator;

    /**
     * AdminService constructor.
     * @param AdminRepository $adminRepository
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param TokenAuthenticator $guardAuthenticator
     */
    public function __construct(AdminRepository $adminRepository, UserPasswordEncoderInterface $passwordEncoder, TokenAuthenticator $guardAuthenticator)
    {
        $this->adminRepository = $adminRepository;
        $this->passwordEncoder = $passwordEncoder;
        $this->guardAuthenticator = $guardAuthenticator;
    }

    /**
     * @param array $authenticationData
     * @return array
     * @throws Exception
     */
    public function authenticate(array $authenticationData): array
    {
        $admin = $this->adminRepository->findOneBy(['email' => $authenticationData['email']]);

        if (!($admin instanceof Admin)) {
            throw new Exception('User with this e-mail has not been found!', 1);
        }

        $result = [];
        if ($this->passwordEncoder->isPasswordValid($admin, $authenticationData['password'])) {
            $result['guardAuthenticator'] = $this->guardAuthenticator;
        }

        return $result;
    }

    private function generateRandomString($length = 32) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
