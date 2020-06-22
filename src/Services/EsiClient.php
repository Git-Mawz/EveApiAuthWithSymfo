<?php

namespace App\Services;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;

class EsiClient extends AbstractController
{

    public $baseEsiUrl = 'https://esi.evetech.net/latest';

    public function getCharacter($characterId)
    {   

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

        $response = $client->request('GET', $this->baseEsiUrl . '/characters/' . $characterId);
        $jsonContent = $response->getContent();
        $character = json_decode($jsonContent);

        return $character;
    }

    public function getCharacterMail($characterId)
    {
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

        $response = $client->request('GET', $this->baseEsiUrl . '/characters/' . $characterId . '/mail');
        $jsonContent = $response->getContent();
        $mails = json_decode($jsonContent);
        
        return $mails;
    }

    public function getCharacterPortrait($characterId)
    {

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
            
        $response = $client->request('GET', $this->baseEsiUrl . '/characters/' . $characterId . '/portrait');
        $jsonContent = $response->getContent();
        $portrait = json_decode($jsonContent);
        
        return $portrait;

    }

}