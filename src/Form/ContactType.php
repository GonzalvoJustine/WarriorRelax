<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => false,
                'attr' => [
                    'autofocus' => true,
                    'placeholder' => "Nom et prénom"
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
                    'placeholder' => "Email"
                ],
                'required' => true,
                'constraints' =>
                    new NotBlank([
                        'message' => 'Veuillez entrer un email'
                    ])
            ])
            ->add('message', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'rows' => 6,
                    'placeholder' => "Message"
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
