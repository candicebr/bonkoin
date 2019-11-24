<?php

namespace App\Form;

use App\Entity\Advert;
use App\Entity\Car;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormBuilderInterface;
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
                    'Choisissezunecatégorie' => '"Choisissezunecatégorie"',
                    'Emploi' => [
                        "Offresd'emplois" => "Offresd'emplois",
                        'Formationsprofessionnelles' => 'Formationsprofessionnelles',
                    ],
                    'Véhicules' => [
                        'Voitures' => 'Voitures',
                        'Motos' => 'Motos',
                        'Caravaning' => 'Caravaning',
                    ],
                    'Immobilier' => [
                        'Ventesimmobilières' => 'Ventes',
                        'Locations' => 'Locations',
                    ],
                    'Vacances' => [
                        'Locations&Gîtes' => 'Locations&Gîtes',
                        "Chambresd'hôtes" => "Chambred'hôte",
                        'Campings' => 'Campings',
                        'Hôtels' => 'Hôtels',
                    ],
                    'Multimédia' => [
                        'Informatique' => 'Informatique',
                        'ConsolesetJeuxvidéo' => 'ConsolesetJeuxvidéo',
                        'Image&Son' => 'Image&Son',
                        'Téléphonie' => 'Téléphonie',
                    ],
                    'maison' => [
                        'Ameublement' => 'Ameublement',
                        'Electroménager' => 'Electroménager',
                        'Artsdelatable' => 'Artsdelatable',
                        'Décoration' => 'Décoration',
                        'Lingedemaison' => 'Lingedemaison',
                        'Bricolage' => 'Bricolage',
                        'Jardinage' => 'Jardinage',
                    ],
                    'Mode' => [
                        'Vêtements' => 'Vêtements',
                        'Chaussures' => 'Chaussures',
                        'Accessoires&Bagagerie' => 'Accessoires&Bagagerie',
                        'Montres&Bijoux' => 'Montres&Bijoux',
                        'Bébé' => 'Bébé',
                    ],
                    'Loisirs' => [
                        'DVD/Films' => 'DVD/Films',
                        'CD/Musique' => 'CD/Musique',
                        'Livres' => 'Livres',
                        'Animaux' => 'Animaux',
                        'Vélos' => 'Vélos',
                        'Sports&Hobbies' => 'Sports&Hobbies',
                        'Instrumentsdemusique' => 'Instrumentsdemusique',
                        'Jeux&Jouets' => 'Jeux&Jouets',
                    ],
                    'Divers' => [
                        'Autres' => 'Autres'
                    ],
                ],
            ])
//->addEventListener(FormEvents::PRE_SET_DATA,
//[$this,'onPreSetData'])

        ;

        $builder->get('advert_category')->addEventListener(FormEvents::PRE_SET_DATA,
            [$this, 'onPreSetData']);
    }


    public function onPreSetData(FormEvent$event) {
        //$advert=$event->getData();
        $form=$event->getForm()->getParent();
        $advert=$form->getData();
        dump($advert);

        if(!$advert){
            return;
        }


        if(isset($advert['advert_category'])&&$advert['advert_category']=='Voitures'){
            $form->getParent()->add('car',CarType::class);
        }
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Advert::class,
        ]);
    }
}
