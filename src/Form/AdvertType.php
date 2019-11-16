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
            ->add('Categorie', ChoiceType::class, [
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
                        'DVD / Films' => 'DVD / Films',
                        'CD / Musique' => 'CD / Musique',
                        'Livres' => 'Livres',
                        'Animaux' => 'Animaux',
                        'Vélos' => 'Vélos',
                        'Sports & Hobbies' => 'Sports & Hobbies',
                        'Instruments de musique' => 'Instruments de musique',
                        'Jeux & Jouets' => 'Jeux & Jouets',
                    ],
                    'Divers' => [
                        'Autres' => 'Autres'
                    ],
                ],
            ])
            ->add('Titre')
            ->add('Description')
            ->add('Prix')
            ->add('Photos')
            ->add('Region')
            ->add('Localisation')

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Advert::class,
        ]);
    }
}
