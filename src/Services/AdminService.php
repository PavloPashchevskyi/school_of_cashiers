<?php
declare(strict_types=1);

namespace App\Services;

use App\Repository\AdminRepository;
use App\Entity\Admin;
use Exception;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminService
{
    /** @var AdminRepository */
    private $adminRepository;

    /** @var UserPasswordEncoderInterface */
    private $passwordEncoder;

    /**
     * AdminService constructor.
     * @param AdminRepository $adminRepository
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(AdminRepository $adminRepository, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->adminRepository = $adminRepository;
        $this->passwordEncoder = $passwordEncoder;
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
            throw new Exception('Admin with this e-mail has not been found!', 1);
        }

        $result = [];
        if ($this->passwordEncoder->isPasswordValid($admin, $authenticationData['password'])) {
            $result = [
                'hr_id' => $admin->getId(),
            ];
        }

        return $result;
    }
}
