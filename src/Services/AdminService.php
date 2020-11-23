<?php
declare(strict_types=1);

namespace App\Services;

use App\Repository\AdminRepository;
use App\Entity\Admin;
use Exception;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use DateTime;

class AdminService
{
    /** @var AdminRepository */
    private $adminRepository;

    /** @var UserPasswordEncoderInterface */
    private $passwordEncoder;

    /** @const int */
    private const TOKEN_TTL = 32400;

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
            throw new Exception('Email указан неверно', 1);
        }

        $result = [];
        if ($this->passwordEncoder->isPasswordValid($admin, $authenticationData['password'])) {
            $token = md5(json_encode(['hr_id' => $admin->getId(),]));
            $result = [
                'hr_id' => $admin->getId(),
                'token' => $token,
            ];

            $admin->setApiToken($token);
            $currentTimestamp = (new DateTime())->format('U');
            $admin->setApiTokenValidUntil($currentTimestamp + self::TOKEN_TTL);
            $this->adminRepository->store($admin);
        }

        return $result;
    }

    /**
     * 
     * @param array $authData
     * @return array
     * @throws Exception
     */
    public function check(array $authData): array
    {
        // check timestamps
        $currentTimestamp = (new DateTime())->format('U');
        if ($currentTimestamp - $authData['timestamp'] > 5) {
            throw new Exception('Превышен интервал ожидания для запроса', 5);
        }

        // check ID of HR-manager
        $admin = $this->adminRepository->find($authData['hr_id']);
        if (!($admin instanceof Admin)) {
            throw new Exception('HR-менеджер НЕ авторизован или время сеанса истекло!', 3);
        }

        if ($admin->getApiToken() !== $authData['token'] || $admin->getApiTokenValidUntil() < $currentTimestamp) {
            throw new Exception('HR-менеджер НЕ авторизован или время сеанса истекло!', 3);
        }
        
        return [
            'hr_id' => $authData['hr_id'],
            'token' => $authData['token'],
        ];
    }

    /**
     * @param array $authData
     * @return array
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function logout(array $authData): array
    {
        $admin = $this->adminRepository->find($authData['hr_id']);
        $admin->setApiToken(null);
        $admin->setApiTokenValidUntil(null);
        $this->adminRepository->store($admin);

        return [
            'code' => 0,
            'message' => 'OK',
        ];
    }
}
