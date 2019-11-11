<?php

namespace App\Form;

use App\Entity\Advert;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AdvertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('advert_category', ChoiceType::class, [
                'choices' => [
                    'véhicules' => 'véhicules',
                    'immobilier' => 'immobilier',
                    'vacances' => 'vacances',
                    'loisirs' => 'loisirs',
                    'mode' => 'mode',
                    'multimédia' => 'multimédia',
                    'emploi' => 'emploi',
                    'maison' => 'maison',
                    'matériel professionnel' => 'matériel professionnel',
                    'services' => 'services',
                    'divers' => 'divers',
                ],
            ])
            ->add('advert_title')
            ->add('advert_description')
            ->add('advert_price')
            ->add('advert_photo')
            ->add('advert_region')
            ->add('advert_localisation')

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Advert::class,
        ]);
    }
}
