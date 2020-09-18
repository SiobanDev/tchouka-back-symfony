<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CompositionController extends AbstractController
{
    /**
     * @Route("/composition", name="composition", methods={"PUT"})
     */
    public function index()
    {
        return $this->render('composition/index.html.twig', [
            'controller_name' => 'CompositionController',
        ]);
    }
}
