<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthenticationSuccessListener
{
    /**
     * @var RequestStack
     */
    private $requestStack;
    
    /**
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }
    
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $successEvent)
    {
        $data = $successEvent->getData();
        $user = $successEvent->getUser();

        if (!$user instanceof UserInterface) {
            return;
        }

        $data['addedData'] = [
            'id' => $user->getId(),
        ];

        $successEvent->setData($data);

    }
}