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
                    'Emploi' => [
                        "Offres d'emplois" => "Offres d'emplois",
                        'Formations professionnelles' => 'Formations professionnelles',
                    ],
                    'Véhicules' => [
                        'Voitures' => 'Voitures',
                        'Motos' => 'Motos',
                    ],
                    'Immobilier' => [
                        'Ventes immobilières' => 'Ventes immobilières',
                        'Locations' => 'Locations',
                    ],
                    /*'Vacances' => [
                        'Locations & Gîtes' => 'Locations & Gîtes',
                        "Chambres d'hôtes" => "Chambre d'hôte",
                        'Campings' => 'Campings',
                        'Hôtels' => 'Hôtels',
                    ],*/
                    'Multimédia' => [
                        'Informatique' => 'Informatique',
                        'Consoles et Jeux vidéo' => 'Consoles et Jeux vidéo',
                        'Image & Son' => 'Image & Son',
                        'Téléphonie' => 'Téléphonie',
                    ],
                    'maison' => [
                        'Ameublement' => 'Ameublement',
                        'Electroménager' => 'Electroménager',
                        'Décoration' => 'Décoration',
                        'Bricolage &' => 'Bricolage',
                        'Jardinage' => 'Jardinage',
                    ],
                    'Mode' => [
                        'Vêtements' => 'Vêtements',
                        'Chaussures' => 'Chaussures',
                        'Accessoires' => 'Accessoires',
                    ],
                    'Loisirs' => [
                        'DVD/Films' => 'DVD/Films',
                        'CD/Musique' => 'CD/Musique',
                        'Livres' => 'Livres',
                        'Animaux' => 'Animaux',
                        'Jeux & Jouets' => 'Jeux & Jouets',
                    ],
                    'Divers' => [
                        'Autres' => 'Autres'
                    ],
                ],'label' => 'Catégorie'
            ])
            ->add('advert_title', null, ['label' => "Titre de l'annonce"])
            ->add('advert_description', null, ['label' => 'Description'])
            ->add('advert_price', null, ['label' => 'Prix'])
            ->add('advert_photo', null, ['label' => 'Photos'])
            ->add('advert_region', null, ['label' => 'Région'])
            ->add('advert_localisation', null, ['label' => 'Adresse'])
        ;

        $formModifier = function(FormInterface $form, Advert $advert = null) {
            if($advert) {
                if ($advert->getAdvertCategory() == 'Voitures') {
                    $form->add('Car', CarType::class);
                }
                else if ($advert->getAdvertCategory() == 'Ventes immobilières' || $advert->getAdvertCategory() == 'Locations') {
                    $form->add('Immovable', ImmovableType::class);
                }
                else if ($advert->getAdvertCategory() == 'Vêtements') {
                    $form->add('Clothe', ClotheType::class);
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
/*
        $builder->get('advert_category')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier)
            {
                $formModifier($event->getForm()->getParent(), $event->getForm()->getData());

            }
        );*/

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Advert::class,
        ]);
    }
}
