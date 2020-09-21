<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\Score;
use App\Repository\ScoreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\Json;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ScoreService
{
    private $scoreRepository;
    private $entityManager;

    public function __construct(ScoreRepository $scoreRepository, EntityManagerInterface $entityManager)
    {
        $this->scoreRepository = $scoreRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @param ValidatorInterface $validator
     * @param UserInterface $connectedUser
     * @param ScoreRepository $scoreRepository
     * @param string $scoreTitle
     * $param array $scoreNoteList
     * @return null
     * @throws Exception
     */
    public function add(ValidatorInterface $validator, UserInterface $connectedUser, string $scoreTitle, array $scoreNoteList)
    {
        $userId = $connectedUser->getUsername();
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
//                $errorsString = (string)$errors;

                $score = null;
                throw new Exception('incorrect score data',500);

            }

            // tell Doctrine you want to (eventually) save the score (no queries yet)
            $this->entityManager->persist($score);

            // actually executes the queries (i.e. the INSERT query)
            $this->entityManager->flush();


            return null;

    }

    public function removeAllScores($user)
    {
        $userId = $user->getId();
        $scoresToDeleteList = $this->scoreRepository->findByUser($userId);

        foreach ($scoresToDeleteList as $scoreToDeleteItem) {

            $user->removeScore($scoreToDeleteItem);
            // actually executes the queries (i.e. the INSERT query)
            $this->entityManager->flush();
        }
        return null;
    }

}
