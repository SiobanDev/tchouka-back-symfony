<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/api/login_check", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        if(!is_null($error)){
            return new JsonResponse(
                $this->serializer->serialize(
                    [
                            "message" => 'Erreur de connexion : ' . $error
                        ],
                    'json'
                ),
                Response::HTTP_FORBIDDEN,
                [],
                true
            );
        }

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        
        return new JsonResponse(
            $this->serializer->serialize(
                $lastUsername,
                'json',
            ),
            Response::HTTP_OK,
            [],
            true
        );
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
