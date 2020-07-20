<?php

namespace App\Controller;

use App\Repository\NoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;


class NoteController extends AbstractController
{

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @Route("/notes", name="notes")
     */
    public function index(NoteRepository $noteRepository)
    {
        $allAvailableNotes = $noteRepository->findAll();

        return new JsonResponse($this->serializer->serialize($allAvailableNotes, 'json'), Response::HTTP_ACCEPTED, [], true);
        
        // return $this->render('note/index.html.twig', [
        //     'controller_name' => 'NoteController',
        // ]);
    }
}
