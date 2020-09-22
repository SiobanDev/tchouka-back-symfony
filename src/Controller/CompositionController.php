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
    private $serializer;
    /**
     * @var CompositionRepository
     */
    private $compositionRepository;

    /**
     * CompositionController constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(
        SerializerInterface $serializer
    ) {
        $this->serializer = $serializer;
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
        $newComposition = new Composition();
        $form = $this->createForm(CompositionType::class, $newComposition);
        $dataAssociativeArray = json_decode($request->getContent(), true);

        $form->submit($dataAssociativeArray);

        if ($form->isSubmitted() && !$form->isValid()) {
            $errors = $form->getErrors();

            return $this->json([
                "message" => 'Vous ne pouvez pas sauvegarder de composition : ' . $errors
            ], Response::HTTP_BAD_REQUEST);
        }

        $this->entityManager->persist($newComposition);
        // actually executes the queries (i.e. the INSERT query)
        $this->entityManager->flush();
            
        return $this->json(null, Response::HTTP_CREATED);
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
        $compositionId = $request->request->get('id');
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
