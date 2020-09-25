<?php
namespace App\Controller;

use App\Entity\Composition;
use App\Entity\Score;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{
    private $entityManager;
    private $userRepository;
    private $serializer;

    /**
     * UserController constructor.
     * @param EntityManagerInterface $entityManager
     * @param UserRepository $userRepository
     * @param SerializerInterface $serializer
     */
    public function __construct(
        SerializerInterface $serializer,
        EntityManagerInterface $entityManager,
        UserRepository $userRepository
    ) {
        $this->serializer = $serializer;
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
                User::GROUP_SELF,
            ]]);
        } else {
            return $this->json([
                "message" => 'Il existe déjà un compte avec cet email.'
            ], Response::HTTP_FORBIDDEN);
        }
    }


    /**
     * @Route("/api/user", methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function display(
    ) {
        // $encoders = [new XmlEncoder(), new JsonEncoder()];
        // $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        // $normalizer = [new ObjectNormalizer($classMetadataFactory)];
        // $serializer = new Serializer($normalizer, $encoders);


        $user = $this->getUser();

        $connectedUserData = $this->userRepository->findOneBy(['id' => $user->getId()]);

        if (empty($connectedUserData)) {
            throw new Exception('Aucune donnée ne correspond à l\'utilisateurice indiqué.e.', Response::HTTP_BAD_REQUEST);
        }

        // return $this->json($connectedUserData, Response::HTTP_OK, ['groups' => [
        //     User::GROUP_SELF,
        //     User::GROUP_SCORES,
        //     Score::GROUP_SELF,
        //     User::GROUP_COMPOSITIONS,
        //     Composition::GROUP_SELF,
        // ]]);

        return $this->json($user->getEmail(), Response::HTTP_OK);        

        // return $this->json($connectedUserData, Response::HTTP_OK, ['groups' => [
        //     'user'
        // ]]);

        // return new JsonResponse(
        //     $serializer->serialize(
        //         $user,
        //         'json'
        //     ),
        //     Response::HTTP_CREATED,
        //     ['groups' => [
        //     'user',
        //     ]],
        //     true
        // );

        //         return new JsonResponse(
        //     $this->serializer->serialize(
        //         $user,
        //         'json'
        //     ),
        //     Response::HTTP_CREATED,
        //     ['groups' => [
        //         'user',
        //     ]],
        //     true
        // );
    }
}
