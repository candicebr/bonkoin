<?php

namespace App\Form;

use App\Entity\Immovable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ImmovableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('immovable_type', ChoiceType::class, [
                'placeholder' => '"Choisissez"',
                'choices' => [
                    'Maison' => 'Maison',
                    'Appartement' => 'Appartement',
                    'Terrain' => 'Terrain',
                    'Parking' => 'Parking',
                    'Autre' => 'Autre'
                ], 'label' => 'Type de bien'
            ])
            ->add('immovable_surface', null, ['label' => 'Surface', 'attr' => ['placeholder' => 'm2']])
            ->add('immovable_room', null, ['label' => 'Pièces'])
            ->add('immovable_energy', ChoiceType::class, [
                'placeholder' => '"Choisissez"',
                'choices' => [
                    'A' => 'A',
                    'B' => 'B',
                    'C' => 'C',
                    'D' => 'D',
                    'E' => 'E',
                    'F' => 'F',
                    'G' => 'G',
                    'H' => 'H',
                    'I' => 'I'
                ], 'label' => 'Classe énergie'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Immovable::class,
        ]);
    }
}
