<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MailController extends AbstractController
{
    /**
     * @Route("/mail", name="display_mail")
     */
    public function displayAll()
    {
        $user = $this->get('session')->get('user');
        dd($user);


        return $this->render('mail/index.html.twig', [
            'controller_name' => 'MailController',
        ]);
    }
}
