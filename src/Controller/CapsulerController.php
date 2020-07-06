<?php

namespace App\Controller;

use App\Repository\CapsulerRepository;
use App\Repository\QuestionRepository;
use App\Services\AuthChecker;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class CapsulerController extends AbstractController
{
    /**
     * @Route("/capsuler/home", name="capsuler_home")
     */
    public function details(AuthChecker $authChecker, CapsulerRepository $cr, QuestionRepository $qr)
    {   
        if ($authChecker->isAuthenticated()) {
            $capsuler = $this->get('session')->get('capsuler');
            $characterID = $capsuler->getEveCharacterID();
            
            $esiBaseUrl = 'https://esi.evetech.net/latest/';
            $characterPortraits = $esiBaseUrl . 'characters/' .$characterID. '/portrait/';
            
            $characterPortraits = json_decode(file_get_contents($characterPortraits));

            // TEST

            dump($capsuler->getQuestions());

            // dd($qr->findAll()[0]->getCapsuler()->getQuestions()[1], $capsuler->getQuestions());
            // dd($cr->findCapsulerQuestionById($capsuler->getId()));

            // TEST

            return $this->render('capsuler/home.html.twig', [
                'portraits' => $characterPortraits,
                'capsuler' => $capsuler,
                ]);

        } else {
            return $this->redirectToRoute('main_home');
        }
    }
}
