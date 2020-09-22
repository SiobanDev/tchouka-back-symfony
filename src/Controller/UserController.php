<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{
  private $serializer;
  private $userRepository;
  private $passwordEncoder;

  /**
   * UserController constructor.
   * @param SerializerInterface $serializer
   * @param EntityManagerInterface $entityManager
   * @param UserRepository $userRepository
   * @param UserService $userService
   */
  public function __construct(
    SerializerInterface $serializer,
    EntityManagerInterface $entityManager,
    UserRepository $userRepository,
    UserPasswordEncoderInterface $passwordEncoder
  ) {
    $this->serializer = $serializer;
    $this->entityManager = $entityManager;
    $this->userRepository = $userRepository;
    $this->passwordEncoder = $passwordEncoder;
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

      return $this->json(
        ["message" => "Erreur lors de la création du compte"],
        Response::HTTP_BAD_REQUEST
      );
    }

    //Check if there is already a user with this email
    $userSearchResults = $this->userRepository->findOneBy(['email' => $dataAssociativeArray['email']]);

    if (empty($userSearchResults)) {
      $user->setPassword($this->passwordEncoder->encodePassword(
        $user,
        $dataAssociativeArray['password']
      ));

      $this->entityManager->persist($user);
      // actually executes the queries (i.e. the INSERT query)
      $this->entityManager->flush();

      return $this->json(
        $user,
        Response::HTTP_CREATED,
        [],
        ['groups' => User::FRONT_DETAILS]
      );
    } else {
      throw new Exception('The email is already used for an account', 403);
    }
  }
}
