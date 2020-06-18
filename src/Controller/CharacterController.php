<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class CharacterController extends AbstractController
{
    /**
     * @Route("/character/details", name="character_details")
     */
    public function details()
    {   
        $user = $this->get('session')->get('user');
        // dd($_SESSION);
        $characterID = $user->getCharacterID();

        $esiBaseUrl = 'https://esi.evetech.net/latest/';
        $characterPortraits = $esiBaseUrl . 'characters/' .$characterID. '/portrait/';

        $characterPortraits = json_decode(file_get_contents($characterPortraits));

        return $this->render('character/details.html.twig', [
            'portraits' => $characterPortraits
        ]);
    }
}
