<?php

namespace App\Form;

use App\Entity\propertySearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertySearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Code',null,['label' => 'Recherche par Code compagnie ',
                'attr' => ['requied' => false,
                    'placeholder' => 'Entrer le code du compagnie'] ] ) ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => propertySearch::class,
        ]);
    }
}
