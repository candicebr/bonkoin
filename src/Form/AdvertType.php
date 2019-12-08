<?php

namespace App\Form;

use App\Entity\Advert;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdvertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('advert_category', ChoiceType::class, [
                'placeholder' => '"Choisissez"',
                'choices' => [
                    'Véhicules' => [
                        'Voitures' => 'Voitures',
                        'Motos' => 'Motos',
                    ],
                    'Immobilier' => [
                        'Ventes immobilières' => 'Ventes immobilières',
                        'Locations' => 'Locations',
                    ],
                    'maison' => [
                        'Ameublement' => 'Ameublement',
                        'Electroménager' => 'Electroménager',
                    ],
                    'Mode' => [
                        'Vêtements' => 'Vêtements',
                        'Chaussures' => 'Chaussures',
                        'Accessoires' => 'Accessoires',
                    ],
                    'Divers' => [
                        'Autres' => 'Autres'
                    ],
                ],'label' => 'Catégorie'
            ])
            ->add('advert_title', null, ['label' => "Titre de l'annonce"])
            ->add('advert_description', null, ['label' => 'Description'])
            ->add('advert_price', null, ['label' => 'Prix'])
            ->add('advert_region', null, ['label' => 'Région'])
            ->add('advert_localisation', null, ['label' => 'Adresse'])
        ;

        $formModifier = function(FormInterface $form, Advert $advert = null) {
            if($advert) {
                if ($advert->getAdvertCategory() == 'Voitures') {
                    $form->add('Car', CarType::class, ['label' => "Plus d'information"]);
                }
                else if ($advert->getAdvertCategory() == 'Motos') {
                    $form->add('Car', MotoType::class, ['label' => "Plus d'information"]);
                }
                else if ($advert->getAdvertCategory() == 'Ventes immobilières' || $advert->getAdvertCategory() == 'Locations') {
                    $form->add('Immovable', ImmovableType::class, ['label' => "Plus d'information"]);
                }
                else if ($advert->getAdvertCategory() == 'Vêtements' || $advert->getAdvertCategory() == 'Chaussures') {
                    $form->add('Clothe', ClotheType::class, ['label' => "Plus d'information"]);
                }
            }
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier)
            {
                $formModifier($event->getForm(), $event->getData());
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Advert::class,
        ]);
    }
}
