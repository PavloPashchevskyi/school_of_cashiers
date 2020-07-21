<?php

namespace App\Controller\Custom;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    protected function isAdminAuthenticated()
    {
        $session = $this->get('session');

        return $session->has('hr_id');
    }
}
