<?php

namespace App\Form;

use App\Entity\OrderItem;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddToCartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('time', TimeType::class, [
                'input'  => 'datetime',
                'widget' => 'choice',
                'with_seconds' => true,
                'placeholder' => [
                    'minute' => 'Minutes', 'second' => 'Secondes',
                ],
            ])
            ->add('quantity')
            ->add('add', SubmitType::class, [
            'label' => 'Ajouter un exercice',
            'attr' => [
                'class' => 'btn btn-white btn-fa-square'
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OrderItem::class,
        ]);
    }
}