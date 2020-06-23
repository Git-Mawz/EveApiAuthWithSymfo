<?php

namespace App\Controller;

use App\Services\AuthChecker;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class CapsulerController extends AbstractController
{
    /**
     * @Route("/character/home", name="character_home")
     */
    public function details(AuthChecker $authChecker)
    {   
        if ($authChecker->isAuthenticated()) {
            $user = $this->get('session')->get('user');
            $characterID = $user->getCharacterID();
            
            $esiBaseUrl = 'https://esi.evetech.net/latest/';
            $characterPortraits = $esiBaseUrl . 'characters/' .$characterID. '/portrait/';
            
            $characterPortraits = json_decode(file_get_contents($characterPortraits));
            
            return $this->render('capsuler/home.html.twig', [
                'portraits' => $characterPortraits,
                'user' => $user
                ]);
        } else {
            return $this->redirectToRoute('main_home');
        }
    }
}
