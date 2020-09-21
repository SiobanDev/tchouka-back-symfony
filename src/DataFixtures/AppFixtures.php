<?php

namespace App\DataFixtures;

use App\Entity\Composition;
use App\Entity\Score;
use App\Entity\User;
use App\FileLoader\JsonFileLoader;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        

        // $finder = new Finder();

        // for ($i = 0; $i < 5; $i++) {
        //     $scoreLength = $faker->randomDigitNot(20);
        //     $availableNotePathList = iterator_to_array($finder->files()->in(__DIR__ . "/Data/AvailableNotes"));
        //     // dd($availableNotePathList);
            
        //     $scoreNoteListTmp = array();

        //     for ($j = 0; $j < $scoreLength; $j++) {
        //         $randomNoteDataFile = $faker->shuffle($availableNotePathList);
        //         $randomScoreNoteData = new JsonFileLoader($randomNoteDataFile);
        //         array_push($randomScoreNoteData);
        //     }

        //     $score = new Score();
        //     $score->setNoteList($scoreNoteListTmp);
        //     $manager->persist($score);
        // }

        
        // for ($i = 0; $i < 5; $i++) {
        //     $compositionLength = $faker->randomDigitNot(20);
        //     $availableNotePathList = iterator_to_array($finder->files()->in(__DIR__ . "/Data/AvailableNotes"));
        //     // dd($availableNotePathList);
            
        //     $compositionNoteListTmp = array();

        //     for ($j = 0; $j < $compositionLength; $j++) {
        //         $randomNoteDataFile = $faker->shuffle($availableNotePathList);
        //         $randomCompositionNoteData = new JsonFileLoader($randomNoteDataFile);
        //         array_push($randomCompositionNoteData);
        //     }
            
        //     $composition = new Composition();
        //     $composition->setMovementList($compositionNoteListTmp);
        //     $manager->persist($composition);
        // }

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
      
            $email = $faker->email;
      
            $user->setEmail($email)
              ->setPassword($this->encoder->encodePassword(
                  $user,
                  'pass_' . $email
              ));
      
            $manager->persist($user);
        }
      
        $manager->flush();
    }
}
