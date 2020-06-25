<?php
declare(strict_types=1);

namespace App\Services;

use App\Repository\AttemptRepository;

class AttemptService
{
    /** @var AttemptRepository */
    private $attemptRepository;

    public function __construct(AttemptRepository $attemptRepository)
    {
        $this->attemptRepository = $attemptRepository;
    }

    public function getUsersAttempts()
    {
        return $this->attemptRepository->getUsersAttempts();
    }
}
