<?php

namespace App\Form;

use App\Entity\Car;
use Doctrine\DBAL\Types\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('car_brand', null, ['label' => 'Marque'])
            ->add('car_date', null, ['label' => 'Année modèle'])
            ->add('car_km', null, ['label' => 'Kilométrage'])
            ->add('car_fuel', ChoiceType::class, [
                'placeholder' => '"Choisissez"',
                'choices' => [
                    'Essence' => 'Essence',
                    'Diesel' => 'Diesel',
                    'Hybride' => 'Hybride',
                    'Electrique' => 'Electrique',
                    'Autre' => 'Autre'
                ],'label' => 'Carburant'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
