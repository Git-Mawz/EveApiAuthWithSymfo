<?php

namespace App\Services;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;

class EsiClient extends AbstractController
{

    private $httpClient;
    private $accessToken;
    private $baseEsiUrl = 'https://esi.evetech.net/latest';

    public function __construct(){

        $this->accessToken = $this->get('session')->get('token')->getToken('accessToken');

        $this->httpClient = HttpClient::create([
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'User-Agent' => 'Krawks',
            ]
        ]);


    }

    public function getCharacter($characterId)
    {
        $response = $this->client->request('GET', $this->baseEsiUrl . '/characters/' . $characterId);
        $jsonContent = $response->getContent();
        $content = json_decode($jsonContent);

        return $content;
    }

    public function getCorporation($corporationId)
    {

    }




}