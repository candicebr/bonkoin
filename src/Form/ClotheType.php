<?php

namespace App\Form;

use App\Entity\Clothe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClotheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('clothe_universe', ChoiceType::class, [
                'placeholder' => '"Choisissez"',
                'choices' => [
                    'Femme' => 'Femme',
                    'Homme' => 'Homme',
                    'Enfant' => 'Enfant'
                ], 'label' => 'Univers'
            ])
            ->add('clothe_type', null, ['label' => 'Type'])
            ->add('clothe_brand', null, ['label' => 'Marque'])
            ->add('clothe_color', null, ['label' => 'Couleur'])
            ->add('clothe_state', ChoiceType::class, [
                'placeholder' => '"Choisissez"',
                'choices' => [
                    'Etat satisfaisant' => 'Etat satisfaisant',
                    'Bon état' => 'Bon état',
                    'Très bon état' => 'Très bon état',
                    'Neuf sans étiquette' => 'Neuf sans étiquette',
                    'Neuf avec étiquette' => 'Neuf avec étiquette'
                ], 'label' => 'Etat'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Clothe::class,
        ]);
    }
}
