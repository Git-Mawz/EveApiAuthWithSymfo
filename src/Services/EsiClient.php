<?php

namespace App\Services;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;

class EsiClient extends AbstractController
{

    private $httpClient;
    private $accessToken;

    public function __construct(){

        $this->accessToken = $this->get('session')->get('token')->getToken('accessToken');

        $this->httpClient = HttpClient::create([
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'User-Agent' => 'Krawks',
            ]
        ]);


    }

    public function getCharacterName($characterId)
    {
       
    }

    public function getCorporationName($corporationId)
    {
        
    }




}