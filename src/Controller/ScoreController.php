<?php

namespace App\Controller;

use App\Entity\Score;
use App\Repository\ScoreRepository;
use App\Service\ScoreService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ScoreController extends AbstractController
{
    private $serializer;
    private $scoreService;
    /**
     * @var ScoreRepository
     */
    private $scoreRepository;

    /**
     * ScoreController constructor.
     * @param SerializerInterface $serializer
     * @param ScoreService $scoreService,
     * @param ScoreRepository $scoreRepository
     */
    public function __construct(
        SerializerInterface $serializer,
        ScoreService $scoreService,
        ScoreRepository $scoreRepository
    ) {
        $this->serializer = $serializer;
        $this->scoreService = $scoreService;
        $this->scoreRepository = $scoreRepository;
    }

    /**
     *
     * @Route("/api/score", methods={"POST"})
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return JsonResponse
     * @throws Exception
     */
    public function add(
        Request $request,
        ValidatorInterface $validator
    ) {
        $connectedUser = $this->getUser();
        $newScore = json_decode($request->getContent(), true);

        $scoreTitle = $request->request->get('scoreTitle');
        $scoreNoteList = $request->request->get('noteList');

        try {
            $score = new Score();
            
            //Get the score with the same parameters as those from the request
    
            //Check if there's already a score with the same parameters as those from the request and prevent the creation if it's the case
            $score->setUser($connectedUser);
            $score->setTitle($scoreTitle);
            $score->setNoteList($scoreNoteList);
    
            $errors = $validator->validate($score);
    
            if (count($errors) > 0) {
                /*
                 * Uses a __toString method on the $errors variable which is a ConstraintViolationList object. This gives us a nice string for debugging.
                 */
                // $errorsString = (string)$errors;
    
                $score = null;
                throw new Exception('incorrect score data', 500);
            }
    
            // tell Doctrine you want to (eventually) save the score (no queries yet)
            $this->entityManager->persist($score);
    
            // actually executes the queries (i.e. the INSERT query)
            $this->entityManager->flush();
    
    
            return new JsonResponse(
                $this->serializer->serialize(
                        $$newScore,
                        'json'
                    ),
                Response::HTTP_CREATED,
                [],
                true
            );
        } catch (\Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     *
     * @Route("/api/scores")
     * @return JsonResponse
     */
    public function displayAll()
    {
        $user = $this->getUser();
        $userId = $user->getId();
        $displayAllScores = $this->scoreRepository->findByUserfindAl($userId);

        return new JsonResponse($this->serializer->serialize($displayAllScores, 'json'), Response::HTTP_OK, [], true);
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
        $scoreId = $request->request->get('scoreId');
        $scoreToDelete = $this->scoreRepository->findOneById($scoreId);

        //Check if the score to delete is in the BDD
        if (empty($scoreToDelete)) {
            throw new Exception('There is no score to delete or you have no right to do it.', Response::HTTP_FORBIDDEN);
        }

        $user->removeScore($scoreToDelete);
        $entityManager->flush();

        return new JsonResponse(
            'The score has been well removed.',
            Response::HTTP_RESET_CONTENT
        );
    }
}
