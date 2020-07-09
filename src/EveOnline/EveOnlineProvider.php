<?php

namespace App\EveOnline;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class EveOnlineProvider
{

    private $eveonlineClientId;
    private $eveonlineSecretKey;
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->eveonlineClientId = $_ENV['CLIENT_ID'];
        $this->eveonlineSecret = $_ENV['SECRET_KEY'];
        $this->httpClient = $httpClient;
    }

    public function loadUserFromEveOnline(string $code)
    {   
        $urlSafe = base64_encode($this->eveonlineClientId . ':' . $this->eveonlineSecretKey);
        $url= 'https://login.eveonline.com/v2/oauth/token';

        $response = $this->httpClient->request('POST', $url, [
            'headers' => [
                'Authorization' => 'Basic ' . $urlSafe,
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Host' => 'login.eveonline.com'
            ],
            'query' => [
                'grant_type' => 'authorization_code',
                'code' => $code
            ]
        ]);

    }

}