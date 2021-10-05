<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Pseudo',
                'attr' => [
                    'autofocus' => true
                ],
                'required' => true,
                'constraints' =>
                    new NotBlank([
                        'message' => 'Veuillez entrer un pseudo'
                    ])
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'autofocus' => true
                ],
                'required' => true,
                'constraints' =>
                    new NotBlank([
                        'message' => 'Veuillez entrer un email'
                    ])
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => "Les mots de passe saisis ne correspondent pas.",
                'required' => true,
                'first_options' => [
                    'label' => "Mot de passe",
                    'attr' => ['autocomplete' => 'new-password'],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez entrer un mot de passe',
                        ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'Pour des raisons de sécurité, votre mot de passe doit être de {{ limit }} caractères',
                            'max' => 4096,
                        ])
                    ],
                ],
                'second_options' => [
                    'label' => "Confirmer le mot de passe",
                    'attr' => [
                        'title' => "Confirmer le mot de passe"
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Entrer un mot de passe',
                        ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'Pour des raisons de sécurité, votre mot de passe doit être de {{ limit }} caractères',
                            'max' => 4096,
                        ])
                    ],
                ],
                'mapped' => false,


            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => "J'accepte les condictions d'utilisation de ce site.",
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les conditions d\'utilisation de ce site pour vous inscrire.',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
