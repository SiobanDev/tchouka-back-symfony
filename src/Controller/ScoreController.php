<?php

namespace App\Controller;

use App\Entity\Score;
use App\Form\ScoreType;
use App\Repository\ScoreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ScoreController extends AbstractController
{
    private $serializer;
    /**
     * @var ScoreRepository
     */
    private $scoreRepository;

    /**
     * ScoreController constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(
        SerializerInterface $serializer
    ) {
        $this->serializer = $serializer;
    }

    /**
     *
     * @Route("/api/score", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function add(
        Request $request
    ) {
        $newScore = new Score();
        $form = $this->createForm(ScoreType::class, $newScore);
        $dataAssociativeArray = json_decode($request->getContent(), true);

        $form->submit($dataAssociativeArray);

        if ($form->isSubmitted() && !$form->isValid()) {
            $errors = $form->getErrors();

            return $this->json([
                "message" => 'Vous ne pouvez pas sauvegarder de partition : ' . $errors
            ], Response::HTTP_BAD_REQUEST);
        }

        $this->entityManager->persist($newScore);
        // actually executes the queries (i.e. the INSERT query)
        $this->entityManager->flush();
            
        return $this->json(null, Response::HTTP_CREATED);
    }

    /**
     * To test the function with Postman, you need to set a 'score_id' key in the headers parameters
     *
     * @Route("/api/score", methods={"DELETE"})
     * @param EntityManagerInterface $entityManager
     * @return JsonResponse
     * @throws NonUniqueResultException
     * @throws Exception
     */
    public function removeOne(
        Request $request,
        EntityManagerInterface $entityManager
    ) {
        $user = $this->getUser();
        $scoreId = $request->request->get('id');
        $scoreToDelete = $this->scoreRepository->findOneById($scoreId);

        //Check if the score to delete is in the BDD
        if (empty($scoreToDelete)) {
            throw new Exception('Il n\'y a pas de partition à supprimer.', Response::HTTP_FORBIDDEN);
        }

        $user->removeScore($scoreToDelete);
        $entityManager->flush();

        return new JsonResponse(
            'La partition a bien été supprimée.',
            Response::HTTP_RESET_CONTENT
        );
    }
}
