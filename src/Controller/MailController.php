<?php

namespace App\Controller;

use App\Services\EsiEndpoints;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Routing\Annotation\Route;

class MailController extends AbstractController
{
    /**
     * @Route("/display_mails", name="display_mails")
     */
    public function displayAll(EsiEndpoints $baseEnPoint)
    {   
        // On récupère les données de l'utilisateurs connecté
        $user = $this->get('session')->get('user');
        $characterId = $user->getCharacterID();
        // On créé le endpoint pour les mails
        $fetchMailEndPoint = $baseEnPoint->baseEsiUrl . 'characters/' . $characterId . '/mail/';

        // On fait une requete à l'API pour récupérer les mails de l'utilisateur connecté

        $tokens = $this->get('session')->get('token');
        $accessToken = $tokens->getToken('accessToken');

        $client = HttpClient::create([
            'headers' => [
                'auth_bearer' => $accessToken,
                'User-Agent' => 'Krawks',
                'Content-Type' => ' application/json'
            ]
        ]);

       
        $response = $client->request('GET', $fetchMailEndPoint);
     


        return $this->render('mail/index.html.twig', [
            'controller_name' => 'MailController',
            'user' => $user
        ]);
    }
}
