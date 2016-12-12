<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('location', TextType::class)
                ->add('transportMode', ChoiceType::class, [
                    'choices' => [
                        'driving' => 'Auto',
                        'walking' => 'Lopen',
                        'bicycling' => 'Fiets',
                        'transit' => 'OV',
                    ],
                ])
                ->add('submit', SubmitType::class, [
                    'label' => 'Zoek',
                ])
        ;
    }
}