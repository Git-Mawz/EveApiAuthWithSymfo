<?php

namespace App\Controller;

use App\Services\EsiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Routing\Annotation\Route;

class MailController extends AbstractController
{
    /**
     * @Route("/mail", name="mail_list")
     */
    public function list(EsiClient $ec)
    {   
        // On récupère les données de l'utilisateurs connecté
        $user = $this->get('session')->get('user');
        $characterId = $user->getCharacterID();

        $mails = $ec->getCharacterMail($characterId);
        $character = $ec->getCharacter($characterId);
        $portrait = $ec->getCharacterPortrait($characterId);

        return $this->render('mail/list.html.twig', [
            'controller_name' => 'MailController',
            'user' => $user,
            'mails' => $mails,
            'character' => $character,
            'portrait' => $portrait
        ]);
    }
}
