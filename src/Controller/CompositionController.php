<?php

namespace App\Controller;

use App\Entity\Composition;
use App\Form\CompositionType;
use App\Repository\CompositionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CompositionController extends AbstractController
{
    private $entityManager;
    private $compositionRepository;

    /**
     * CompositionController constructor.
     * @param EntityManagerInterface $entityManager
     * @param CompositionRepository $compositionRepository
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        CompositionRepository $compositionRepository
    ) {
        $this->entityManager = $entityManager;
        $this->compositionRepository = $compositionRepository;
    }

    /**
     *
     * @Route("/api/composition", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function add(
        Request $request
    ) {
                //TODO : add a JSON asset in the Score entity, add the field noteList in the ScoreType and try to resolve bug of noteList type

        $newComposition = new Composition();
        $form = $this->createForm(CompositionType::class, $newComposition);
        $dataAssociativeArray = json_decode($request->getContent(), true);
        $dataAssociativeArray['movementList'] = json_decode($dataAssociativeArray['movementList'], true);

        $form->submit($dataAssociativeArray);

        if ($form->isSubmitted() && !$form->isValid()) {
            $errors = $form->getErrors();

            return $this->json([
                "message" => 'Vous ne pouvez pas sauvegarder de composition : ' . $errors
            ], Response::HTTP_BAD_REQUEST);
        }

        $newComposition->setMovementList($dataAssociativeArray['movementList']);


        $this->entityManager->persist($newComposition);
        // actually executes the queries (i.e. the INSERT query)
        $this->entityManager->flush();
            
        return $this->json(null, Response::HTTP_CREATED);
    }


    /**
     *
     * @Route("/api/compositions", methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function displayAll(
        ) {
            $user = $this->getUser();
    
            $compositionData = $this->compositionRepository->findByUser($user->getId());
    
            if (empty($compositionData)) {
                throw new Exception('Aucune donnée ne correspond à l\'utilisateurice indiqué.e.', Response::HTTP_BAD_REQUEST);
            }
    
            $movementsCompositionData = [];
    
            for ($i = 0; $i < count($compositionData); $i++) {
                $composition = ["id" => $compositionData[$i]->getId(), "title" => $compositionData[$i]->getTitle(), "notes" => $compositionData[$i]->getMovementList() ];
                array_push($movementsCompositionData, $composition);
            }
    
            return $this->json($movementsCompositionData, Response::HTTP_OK);    
        }

    /**
     * To test the function with Postman, you need to set a 'composition_id' key in the headers parameters
     *
     * @Route("/api/composition", methods={"DELETE"})
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
        $compositionId = json_decode($request->getContent(), true);
        $compositionToDelete = $this->compositionRepository->findOneById($compositionId);

        //Check if the composition to delete is in the BDD
        if (empty($compositionToDelete)) {
            throw new Exception('Il n\'y a pas de composition à supprimer.', Response::HTTP_FORBIDDEN);
        }

        $user->removeComposition($compositionToDelete);
        $entityManager->flush();

        return new JsonResponse(
            'La composition a bien été supprimée.',
            Response::HTTP_RESET_CONTENT
        );
    }
}
