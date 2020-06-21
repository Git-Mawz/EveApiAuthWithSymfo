<?php

namespace App\Controller;

use App\Entity\Character;
use App\Entity\User;
use App\Repository\CharacterRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;

class OAuthController extends AbstractController
{
    /**
     * @Route("/login", name="oauth")
     */
    public function login(CharacterRepository $characterRepository)
    {   
        // Création de la session de symfony
        $session = new Session();
        $session->start();

        // Création du provider OAuth
        $provider = new \Evelabs\OAuth2\Client\Provider\EveOnline([
            'clientId'          => $_ENV['CLIENT_ID'],
            'clientSecret'      => $_ENV['SECRET_KEY'],
            'redirectUri'       => 'http://localhost:8000/login',
        ]);
        
        if (!isset($_GET['code'])) {
        
            // here we can set requested scopes but it is totally optional
            // make sure you have them enabled on your app page at
            // https://developers.eveonline.com/applications/
            // Ici on gère les scopes de l'API pour les futurs requêtes authentifiées
            $options = [
                'scope' => ['esi-mail.read_mail.v1', 'esi-mail.send_mail.v1'] // array or string
            ];
        
            // If we don't have an authorization code then get one
            $authUrl = $provider->getAuthorizationUrl($options);
            $_SESSION['oauth2state'] = $provider->getState();
            unset($_SESSION['token']);
            header('Location: '.$authUrl);
            exit;
        
        // Check given state against previously stored one to mitigate CSRF attack
        } elseif (empty($_GET['state'])) {
        
            unset($_SESSION['oauth2state']);
            exit('Invalid state');
        
        } else {
            // In this example we use php native $_SESSION as data store
            if(!isset($_SESSION['token']))
            {
                // Try to get an access token (using the authorization code grant)
                $_SESSION['token'] = $provider->getAccessToken('authorization_code', [
                    'code' => $_GET['code']
                ]);
        
            }elseif($_SESSION['token']->hasExpired()){
                // This is how you refresh your access token once you have it
                $new_token = $provider->getAccessToken('refresh_token', [
                    'refresh_token' => $_SESSION['token']->getRefreshToken()
                ]);
                // Purge old access token and store new access token to your data store.
                $_SESSION['token'] = $new_token;
            }
        
            // Optional: Now you have a token you can look up a users profile data
            try {
        
                // We got an access token, let's now get the user's details
                $user = $provider->getResourceOwner($_SESSION['token']);

                // ! Use these details to create a new profile

                // On cherche si le characterOwnerHash existe en BDD dans la table character
                $loggedCharacterOwnerHash = $user->getCharacterOwnerHash();
                $storedCharacter = $characterRepository->findOneBy(['characterOwnerHash' => $loggedCharacterOwnerHash]);
                
                // Si il n'existe pas, on créé un nouveau personnage grâce aux characterOwnerHash fourni par
                // l'authentification OAuth à Eve Online
                if ($storedCharacter == null) {
                    $em = $this->getDoctrine()->getManager();
                
                    // On créé le personnage en BDD
                    $newCharacter = new Character();
                    $newCharacter->setName($user->getCharacterName());
                    $newCharacter->setEveCharacterId($user->getCharacterId());
                    $newCharacter->setCharacterOwnerHash($user->getCharacterOwnerHash());

                    $em->persist($newCharacter);
                    $em->flush();
                }

                // printf('Hello %s! ', $user->getCharacterName());
        
            } catch (\Exception $e) {
        
                // Failed to get user details
                exit('Oh dear...');
            }
        }
        
            // Use this to interact with an API on the users behalf
            // printf('Your access token is: %s', $_SESSION['token']->getToken());

            // mise en session du token fourni par oauth
            $session->set('token', $_SESSION['token']);
            // mise en session de l'objet user fourni par le provider
            $session->set('user', $user);
            

        // return $this->render('character/home.html.twig', [
        //     'controller_name' => 'OAuthController',
        //     'user' => $user
        // ]);


        return $this->redirectToRoute('character_home');
    }


    /**
    * @Route("/logoff", name="logoff")
    */

    public function logoff()
    {
        $client = HttpClient::create();
        $client->request('GET', 'https://login.eveonline.com/Account/LogOff');
        $session = $this->get('session');
        $session->clear();

        return $this->redirectToRoute('main');
    }


}