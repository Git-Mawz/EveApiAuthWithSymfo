<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Routing\Annotation\Route;

class MailController extends AbstractController
{
    /**
     * @Route("/character/mails", name="character_mails")
     */
    public function displayAll()
    {   
        // On récupère les données de l'utilisateurs connecté
        $user = $this->get('session')->get('user');
        $characterId = $user->getCharacterID();
        // On créé le endpoint pour les mails
        $esiBaseUrl = 'https://esi.evetech.net/latest/';
        $fetchMailEndPoint = $esiBaseUrl . 'characters/' . $characterId . '/mail/';

        //On récupère le token dans la session
        $tokens = $this->get('session')->get('token');
        // dd($tokens);
        $accessToken = $tokens->getToken('accessToken');

        // On créé le client pour la requête
        $client = HttpClient::create([
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
                'User-Agent' => 'Krawks',
            ]
        ]);

        // On fait la requête
        $response = $client->request('GET', $fetchMailEndPoint);
        // On récupère le contenu de la réponse
        $jsonContent = $response->getContent();
        $content = json_decode($jsonContent);
        dd($content);

        return $this->render('mail/index.html.twig', [
            'controller_name' => 'MailController',
            'user' => $user,
        ]);
    }
}
