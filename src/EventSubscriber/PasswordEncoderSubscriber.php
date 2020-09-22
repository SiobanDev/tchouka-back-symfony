<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Doctrine\ORM\Event\LifecycleEventArgs;
use App\Mail\SymfonyMailer;
use App\Security\TokenGenerator;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Events;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

//Permet d'envoyer le mail de confirmation
// il s'agit d'un doctrine eventSubscriber et non plus d'un symfony eventsubscriber
// la différence est que les events se déclenchent sur les événements en relation avec la base de données
class PasswordEncoderSubscriber implements EventSubscriberInterface
{
    private $encoder;

    /**
     * PasswordEncoderSubscriber constructor.
     * @param UserPasswordEncoderInterface $encoder
     * @param TokenGenerator $tokenGenerator
     * @param SymfonyMailer $mailer
     */
    public function __construct(
        UserPasswordEncoderInterface $encoder
    ) {
        $this->encoder = $encoder;
    }

    public function getSubscribedEvents()
    {
        return [
            Events::prePersist
          ];
    }


    public function prePersist(LifecycleEventArgs $args)
    {
        $user = $args->getEntity();

        if (!$user instanceof User) {
            return;
        }

        $user->setPassword($this->encoder->encodePassword($user, $user->getPassword()));
    }
}
