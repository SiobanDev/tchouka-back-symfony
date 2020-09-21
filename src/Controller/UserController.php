<?php
namespace App\Controller;

use App\Repository\UserRepository;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{
    private $serializer;
    private $entityManager;
    private $userRepository;
    private $userService;
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
        UserService $userService
    ) {
        $this->serializer = $serializer;
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    /**
     * @Route("/api/login/sign-in", methods={"POST"})
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return JsonResponse
     * @throws Exception
     */
    public function create(
        Request $request,
        ValidatorInterface $validator
    ) {
        try {
            $user = $this->userService->add($request, $validator, $this->entityManager, $this->userRepository);

            return new JsonResponse(
                $this->serializer->serialize(
                    $user,
                    'json'
                ),
                Response::HTTP_CREATED,
                [],
                true
            );
        } catch (\Exception $e) {
            return new JsonResponse(
                $this->serializer->serialize(
                    [
                        "message" => 'DATA DO NOT RESPECT CONSTRAINTS ' . $e->getMessage()
                    ],
                    'json'
                ),
                Response::HTTP_FORBIDDEN,
                [],
                true
            );
        }
    }

    // /**
    //  * @Route("/api/login_check", methods={"POST"})
    //  * @return JsonResponse
    //  * @throws Exception
    //  */
    // public function getConnectedUser()
    // {
    //     $user = $this->getUser();
    //     return $this->json([
    //         "username" => $user->getLogin()
    //     ]);
    // }

}
