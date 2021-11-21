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
    /**
     * Build a form with html attributes and Validator constraints.
     *
     * @param FormBuilderInterface<callable> $builder
     * @param array<mixed> $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label' => false,
                'attr' => [
                    'autofocus' => true,
                    'placeholder' => "Pseudo",
                    'class' => 'form-control',
                ],
                'required' => true,
                'constraints' =>
                    new NotBlank([
                        'message' => 'Veuillez entrer un pseudo'
                    ])
            ])
            ->add('email', EmailType::class, [
                'label' => false,
                'attr' => [
                    'autofocus' => true,
                    'placeholder' => "Email",
                    'class' => 'form-control'
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
                    'label' => false,
                    'attr' => [
                        'autocomplete' => 'new-password',
                        'placeholder' => "Mot de passe",
                        'class' => 'form-control'
                    ],
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
                    'label' => false,
                    'attr' => [
                        'title' => "Confirmer le mot de passe",
                        'placeholder' => "Confirmation du mot de passe",
                        'class' => 'form-control'
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
                'label' => "J'accepte les conditions d'utilisation de ce site.",
                'label_attr' => [
                    'class' => 'label-true'
                ],
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
