<?php


namespace App\Form;


use App\Entity\AdvertSearch;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class AdvertSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', ChoiceType::class, [
                'placeholder' => '"Choisissez Catégorie"',
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
                ],'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Catégorie'
                ]
            ])
            ->add('price', MoneyType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Budget max'
                ]
            ])
            ->add('region', null, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Region'
                ]
            ])
        ;

        $formModifier = function(FormInterface $form, AdvertSearch $search) {
            if ($search->getCategory() == 'Voitures') {
                $form
                    ->add('car_brand', TextType::class, [
                        'required' => false,
                        'label' => false,
                        'attr' => [
                            'placeholder' => 'Marque'
                        ]])
                    ->add('car_date', null, [
                        'required' => false,
                        'label' => false,
                        'attr' => [
                            'placeholder' => 'Année min'
                        ]])
                    ->add('car_km', null, [
                        'required' => false,
                        'label' => false,
                        'attr' => [
                            'placeholder' => 'Kilométrage max'
                        ]])
                    ->add('car_fuel', ChoiceType::class, [
                        'placeholder' => '"Choisissez Carburant"',
                        'choices' => [
                            'Essence' => 'Essence',
                            'Diesel' => 'Diesel',
                            'Hybride' => 'Hybride',
                            'Electrique' => 'Electrique',
                            'Autre' => 'Autre'
                        ],'required' => false,
                        'label' => false,])
                ;
            }
            else if ($search->getCategory() == 'Ventes immobilières' || $search->getCategory() == 'Locations') {
                $form
                    ->add('immovable_type', ChoiceType::class, [
                        'placeholder' => '"Choisissez Type"',
                        'choices' => [
                            'Maison' => 'Maison',
                            'Appartement' => 'Appartement',
                            'Terrain' => 'Terrain',
                            'Parking' => 'Parking',
                            'Autre' => 'Autre'
                        ], 'required' => false,
                        'label' => false,
                        ])
                    ->add('immovable_surface', IntegerType::class, [
                        'required' => false,
                        'label' => false,
                        'attr' => [
                            'placeholder' => 'Surface min'
                        ]])
                    ->add('immovable_room', IntegerType::class, [
                        'required' => false,
                        'label' => false,
                        'attr' => [
                            'placeholder' => 'Pièce min'
                        ]])
                    ->add('immovable_energy', ChoiceType::class, [
                        'placeholder' => '"Choisissez Classe Energie"',
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
                        ], 'required' => false,
                        'label' => false,
                        ])
                ;

            }
            else if ($search->getCategory() == 'Vêtements') {
                $form
                    ->add('clothe_universe', ChoiceType::class, [
                        'placeholder' => '"Choisissez Univers"',
                        'choices' => [
                            'Femme' => 'Femme',
                            'Homme' => 'Homme',
                            'Enfant' => 'Enfant'
                        ], 'required' => false,
                        'label' => false,
                    ])
                    ->add('clothe_type', TextType::class, [
                        'required' => false,
                        'label' => false,
                        'attr' => [
                            'placeholder' => 'Type de vêtement'
                        ]])
                    ->add('clothe_brand', TextType::class, [
                        'required' => false,
                        'label' => false,
                        'attr' => [
                            'placeholder' => 'Marque'
                        ]])
                    ->add('clothe_color', TextType::class, [
                        'required' => false,
                        'label' => false,
                        'attr' => [
                            'placeholder' => 'Couleur'
                        ]])
                    ->add('clothe_state', ChoiceType::class, [
                        'placeholder' => '"Choisissez Etat"',
                        'choices' => [
                            'Etat satisfaisant' => 'Etat satisfaisant',
                            'Bon état' => 'Bon état',
                            'Très bon état' => 'Très bon état',
                            'Neuf sans étiquette' => 'Neuf sans étiquette',
                            'Neuf avec étiquette' => 'Neuf avec étiquette',
                        ],
                        'required' => false,
                        'label' => false,
                    ]);
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
            'data_class' => AdvertSearch::class,
            'method' => 'get',
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}