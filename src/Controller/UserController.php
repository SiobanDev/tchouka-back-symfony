<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractController
{
    private $entityManager;
    private $userRepository;

    /**
     * UserController constructor.
     * @param EntityManagerInterface $entityManager
     * @param UserRepository $userRepository
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        UserRepository $userRepository
    ) {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/api/sign-in", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function create(
        Request $request
    ) {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $dataAssociativeArray = json_decode($request->getContent(), true);

        $dataAssociativeArray['email'] = $dataAssociativeArray['username'];
        unset($dataAssociativeArray['username']);

        $form->submit($dataAssociativeArray);

        if ($form->isSubmitted() && !$form->isValid()) {
            $errors = $form->getErrors();

            return $this->json([
                "message" => 'Vous ne pouvez pas créer de compte : ' . $errors
            ], Response::HTTP_BAD_REQUEST);
        }

        //Check if there is already a user with this email
        $userSearchResults = $this->userRepository->findOneBy(['email'=> $dataAssociativeArray['email']]);

        if (empty($userSearchResults)) {
            $user->setPassword(
                $dataAssociativeArray['password']
            );

            $this->entityManager->persist($user);
            // actually executes the queries (i.e. the INSERT query)
            $this->entityManager->flush();
            
            return $this->json(null, Response::HTTP_CREATED, ['groups' => [
                User::FRONT_DETAILS,
            ]]);
        } else {
            return $this->json([
                "message" => 'Il existe déjà un compte avec cet email.'
            ], Response::HTTP_FORBIDDEN);
        }
    }
}
