<?php

namespace App\Services;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AuthChecker extends AbstractController
{
    public function isAuthenticated()
    {
        $session = $this->get('session');
        if (($session->get('capsuler'))) {
            return true;
        } else {
            $session->getFlashBag()->add('notice', 'Vous devez être connecté pour accéder à cette partie de Eve Quantum');
            return false;
        }
    }
}