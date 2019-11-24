<?php

namespace App\Form;

use App\Entity\Advert;
use App\Entity\Car;
use App\Form\CarType;
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
            ->add('advert_title')
            ->add('advert_description')
            ->add('advert_price')
            ->add('advert_photo')
            ->add('advert_region')
            ->add('advert_localisation')
            ->add('advert_category', ChoiceType::class, [
                'choices' => [
                    'Choisissez une catégorie' => '"Choisissez une catégorie"',
                    'Emploi' => [
                        "Offres d'emplois" => "Offres d'emplois",
                        'Formations professionnelles' => 'Formations professionnelles',
                    ],
                    'Véhicules' => [
                        'Voitures' => 'Voitures',
                        'Motos' => 'Motos',
                        'Caravaning' => 'Caravaning',
                    ],
                    'Immobilier' => [
                        'Ventes immobilières' => 'Ventes',
                        'Locations' => 'Locations',
                    ],
                    'Vacances' => [
                        'Locations & Gîtes' => 'Locations & Gîtes',
                        "Chambres d'hôtes" => "Chambre d'hôte",
                        'Campings' => 'Campings',
                        'Hôtels' => 'Hôtels',
                    ],
                    'Multimédia' => [
                        'Informatique' => 'Informatique',
                        'Consoles et Jeux vidéo' => 'Consoles et Jeux vidéo',
                        'Image & Son' => 'Image & Son',
                        'Téléphonie' => 'Téléphonie',
                    ],
                    'maison' => [
                        'Ameublement' => 'Ameublement',
                        'Electroménager' => 'Electroménager',
                        'Arts de la table' => 'Arts de la table',
                        'Décoration' => 'Décoration',
                        'Linge de maison' => 'Linge de maison',
                        'Bricolage' => 'Bricolage',
                        'Jardinage' => 'Jardinage',
                    ],
                    'Mode' => [
                        'Vêtements' => 'Vêtements',
                        'Chaussures' => 'Chaussures',
                        'Accessoires & Bagagerie' => 'Accessoires & Bagagerie',
                        'Montres & Bijoux' => 'Montres & Bijoux',
                        'Bébé' => 'Bébé',
                    ],
                    'Loisirs' => [
                        'DVD/Films' => 'DVD/Films',
                        'CD/Musique' => 'CD/Musique',
                        'Livres' => 'Livres',
                        'Animaux' => 'Animaux',
                        'Vélos' => 'Vélos',
                        'Sports&Hobbies' => 'Sports&Hobbies',
                        'Instruments de musique' => 'Instruments de musique',
                        'Jeux & Jouets' => 'Jeux & Jouets',
                    ],
                    'Divers' => [
                        'Autres' => 'Autres'
                    ],
                ],
            ])
        ;

        $formModifier = function(FormInterface $form, Advert $advert = null) {
            if($advert) {
                if ($advert->getAdvertCategory() == 'Voitures') {
                    $form->add('Car', CarType::class);
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
