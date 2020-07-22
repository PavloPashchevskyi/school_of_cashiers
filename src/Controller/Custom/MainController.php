<?php

namespace App\Controller\Custom;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    protected function isAdminAuthenticated()
    {
        $session = $this->get('session');
        $request = $this->get('request_stack')->getCurrentRequest();
        $requestContent = json_decode($request->getContent(), true);

        return $session->has('hr_id') && !empty($requestContent['token']) && $requestContent['token'] === $session->getId();
    }
}
