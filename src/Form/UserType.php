<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Regex;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'constraints' => [
                            new NotBlank([
                                'message' => 'L\'email doit être défini',
                            ]),
                            new Regex([
                                'pattern' => "/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/",
                                'message' => "L'email n'est pas au bon format."
                            ]),
                        ],
            ])
            ->add('roles', null, ['empty_data' => ['ROLE_USER']])
            ->add('password', TextType::class, [
                'constraints' => [
                            new NotBlank([
                                'message' => 'Le mot de passe doit être défini.',
                            ]),
                            new Regex([
                                'pattern' => "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@\.%_])([-+!*\.$@%_\w]).{8,50}",
                                'message' => "Le mot de passe doit contenir au minimum 8 caratères, donc au moins trois des quatres types suivants : majuscules, minuscules, chiffres, caratères spéciaux"
                            ]),
                        ],
            ])
            ->add('scores', null, ['empty_data' => []])
            ->add('compositions', null, ['empty_data' => []])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // 'data_class' => User::class,
            'csrf_protection' => false,
            'validation_groups' => false,
        ]);
    }
}
