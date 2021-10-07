<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('gender', ChoiceType::class, [
                'label' => false,
                'attr' => [
                    'autofocus' => true,
                    'placeholder' => "Genre"
                ],
                'choices' => [
                    'Mr' => 'Mr',
                    'Mme' => 'Mme',
                ],
                'required' => false
            ])
            ->add('username', TextType::class, [
                'label' => false,
                'attr' => [
                    'autofocus' => true,
                    'placeholder' => "Pseudo"
                ],
                'required' => true,
                'constraints' =>
                    new NotBlank([
                        'message' => 'Veuillez entrer un pseudo'
                    ])
            ])
            ->add('lastname', TextType::class, [
                'label' => false,
                'attr' => [
                    'autofocus' => true,
                    'placeholder' => "Nom"
                ],
                'required' => false
            ])
            ->add('firstname', TextType::class, [
                'label' => false,
                'attr' => [
                    'autofocus' => true,
                    'placeholder' => "Prénom"
                ],
                'required' => false
            ])
            ->add('birthday', BirthdayType::class, [
                'label' => false,
                'attr' => [
                    'autofocus' => true,
                    'placeholder' => "Date de naissance"
                ],
                'required' => false
            ])
            ->add('email', EmailType::class, [
                'label' => false,
                'attr' => [
                    'autofocus' => true,
                    'placeholder' => "Email"
                ],
                'required' => true
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
