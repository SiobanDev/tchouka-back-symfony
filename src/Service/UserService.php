<?php
namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\ScoreService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserService
{
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    /**
     * @param Request $request
     * @param ValidatorInterface $validator
     * @param EntityManagerInterface $entityManager
     * @param UserRepository $userRepository
     * @return User|null
     * @throws Exception
     */
    public function add(
        Request $request,
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager,
        UserRepository $userRepository
    )
    {
        $user = new User();
        //Here, without Symfony's Form (see HOC2019_GIFTS-LB for Symfony Form Use)
        $password = $request->request->get('password');
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            $password
        ));
        $email = $request->request->get('email');
        $userSearchResults = $userRepository->findByMail($email);
        //Check if there is already a user with this email
        if (empty($userSearchResults)) {
            $user->setEmail($email);
        } else {
            throw new Exception('The email is already used for an account', 403);
        }
        $roles = $user->getRoles();
        $user->setRoles($roles);
        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            /*
             * Uses a __toString method on the $errors variable which is a ConstraintViolationList object. This gives us a nice string for debugging.
             */
//            $errorsString = (string)$errors;
//
//            throw new Exception($errorsString);
            $user = null;
            throw new Exception('incorrect user data', 403);
        }
        /* you can fetch the EntityManager via $this->getDoctrine()->getManager() or you can add an argument to the action: addUser(EntityManagerInterface $entityManager)
        */
        // tell Doctrine you want to (eventually) save the user (no queries yet)
        $entityManager->persist($user);
        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
        return $user;
    }

    public function delete(
        EntityManagerInterface $entityManager,
        UserRepository $userRepository,
        ScoreService $scoreService,
        $user
    )
    {
        $userId = $user->getId();
        //First delete all the votes of the connected user
        $scoreService->removeAllScores($user);
        //Then delete the user in the DBB
        $userToDelete = $userRepository->findOneById($userId);
        $entityManager->remove($userToDelete);
        $entityManager->flush();
        return 'The user has been well deleted.';
    }
}
