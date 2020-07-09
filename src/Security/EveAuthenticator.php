<?php

namespace App\Security;

use App\Entity\Capsuler;
use App\EveOnline\EveOnlineProvider;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class EveAuthenticator extends AbstractGuardAuthenticator
{

    private $provider;

    public function __construct(EveOnlineProvider $provider)
    {
        $this->provider = $provider;
    }

    public function supports(Request $request)
    {   
        return $request->query->get('code');
    }

    public function getCredentials(Request $request)
    {   
        return [
            'code' => $request->query->get('code'),
            'state' => $request->query->get('state')
        ];

    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $this->provider->loadUserFromEveOnline($credentials['code']);
        return new Capsuler();
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        // todo
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // todo
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        // todo
        return new JsonResponse("Unauthorized");
    }

    public function supportsRememberMe()
    {
        // todo
    }
}
