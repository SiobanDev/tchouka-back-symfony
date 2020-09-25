<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTExpiredEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTFailureEventInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTInvalidEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTNotFoundEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationFailureResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthenticationFailureListener
{
    
/**
 * @param JWTFailureEventInterface $event
 */
    public function onAuthenticationFailureResponse(JWTFailureEventInterface $event)
    {
        $data = [
        'status'  => '401 Unauthorized',
        'message' => 'Vous n\'êtes pas autorisé.e à faire cette action.',
    ];

        $response = new JWTAuthenticationFailureResponse($data);

        $event->setResponse($response);
    }

    /**
     * @param JWTInvalidEvent $event
     */
    public function onJWTInvalid(JWTFailureEventInterface $event)
    {
        $response = new JWTAuthenticationFailureResponse('Vous n\êtes plus authentifié.e. (token invalide)', 403);

        $event->setResponse($response);
    }


    /**
     * @param JWTNotFoundEvent $event
     */
    public function onJWTNotFound(JWTFailureEventInterface $event)
    {
        $data = [
        'status'  => '403 Forbidden',
        'message' => 'Vous n\êtes pas authentifié.e (token manquant).',
    ];

        $response = new JsonResponse($data, 403);

        $event->setResponse($response);
    }

    /**
     * @param JWTExpiredEvent $event
     */
    public function onJWTExpired(JWTFailureEventInterface $event)
    {
        /** @var JWTAuthenticationFailureResponse */
        $response = $event->getResponse();

        $response->setMessage('Vous n\êtes plus authentifié.e (veuillez renouveler votre token).');
    }
}
