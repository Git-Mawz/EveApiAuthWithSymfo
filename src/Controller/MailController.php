<?php

namespace App\Controller;

use App\Services\AuthChecker;
use App\Services\EsiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Routing\Annotation\Route;

class MailController extends AbstractController
{
    /**
     * @Route("/mail/list", name="mail_list")
     */
    public function list(EsiClient $ec, AuthChecker $authChecker)
    {   
        if ($authChecker->isAuthenticated()) {
            // On récupère les données de l'utilisateurs connecté
            $user = $this->get('session')->get('user');
            $characterId = $user->getCharacterID();
            
            $mails = $ec->getCharacterMail($characterId);
            
            return $this->render('mail/list.html.twig', [
                'user' => $user,
                'mails' => $mails,
                ]);
        } else {
            return $this->redirectToRoute('main_home');
        }
    }
}
