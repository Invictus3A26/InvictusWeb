<?php

namespace App\Form;

use App\Entity\Airport;
use App\Entity\Escale;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EscaleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('aeroportDepart',EntityType::class,['class' => Airport::class,
            'choice_label' => 'nom_aeroport'])
            ->add('aeroportDestination',EntityType::class,['class' => Airport::class,
            'choice_label' => 'nom_aeroport'])
            ->add('heurearriveescale')
            ->add('heuredepartescale')
            ->add('duree')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Escale::class,
        ]);
    }
}
