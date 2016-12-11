<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('location', 'text')
                ->add('transportMode', 'choice', [
                    'choices' => [
                        'driving' => 'Auto',
                        'walking' => 'Lopen',
                        'bicycling' => 'Fiets',
                        'transit' => 'OV',
                    ],
                ])
                ->add('submit', 'submit', [
                    'label' => 'Zoek',
                ])
        ;
    }
}