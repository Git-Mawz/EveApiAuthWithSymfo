<?php

namespace App\Controller;

use App\Services\EsiEndpoints;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;


class CharacterController extends AbstractController
{
    /**
     * @Route("/character/details", name="character_details")
     */
    public function details(SessionInterface $session)
    {   
        $user = $session->get('user');
        $characterID = $user->getCharacterID();

        $esiBaseUrl = 'https://esi.evetech.net/latest/';
        $characterPortrait = $esiBaseUrl . 'characters/' .$characterID. '/portrait/';

        dump($characterID);
        $characterPortraits = json_decode(file_get_contents($characterPortrait));

        return $this->render('character/details.html.twig', [
            'portraits' => $characterPortraits
        ]);
    }
}
