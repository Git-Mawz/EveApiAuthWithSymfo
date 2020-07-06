<?php

namespace App\Controller;

use App\Repository\CapsulerRepository;
use App\Services\AuthChecker;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class CapsulerController extends AbstractController
{
    /**
     * @Route("/capsuler/home", name="capsuler_home")
     */
    public function details(AuthChecker $authChecker, CapsulerRepository $capsulerRepository)
    {   
        if ($authChecker->isAuthenticated()) {

            $characterOwnerHash = $this->get('session')->get('characterOwnerHash');
            $capsuler = $capsulerRepository->findOneBy(['characterOwnerHash' => $characterOwnerHash]);
            $characterID = $capsuler->getEveCharacterID();
            
            $esiBaseUrl = 'https://esi.evetech.net/latest/';
            $characterPortraits = $esiBaseUrl . 'characters/' .$characterID. '/portrait/';
            
            $characterPortraits = json_decode(file_get_contents($characterPortraits));

            return $this->render('capsuler/home.html.twig', [
                'portraits' => $characterPortraits,
                'capsuler' => $capsuler,
                ]);

        } else {
            return $this->redirectToRoute('main_home');
        }
    }
}
