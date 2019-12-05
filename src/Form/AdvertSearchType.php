<?php


namespace App\Form;


use App\Entity\AdvertSearch;
use Doctrine\DBAL\Types\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;

class AdvertSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('minSurface', IntegerType::class, [
                'required' => false,
                'label' => false,
                attr => [
                    'placeholder' => 'Surface minimale'
                ]
            ])
            ->add('maxPrice', IntegerType::class, [
                'required' => false,
                'label' => false,
                attr => [
                    'placeholder' => 'Budget max'
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AdvertSearch::class,
            'method' => 'get',
            'csrf_protection' => false,
        ]);
    }
}