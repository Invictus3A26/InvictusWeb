<?php

namespace App\Form;

use App\Entity\Bagage;
use App\Entity\Fraisbagage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class FraisbagageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('poids')
            ->add('dimension')
            ->add('tarifs_base')
            ->add('tarifs_confort')
            ->add('montant')
            ->add('bagage_id' ,EntityType::class,['class' => Bagage::class,
                'choice_label' => 'id'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Fraisbagage::class,
        ]);
    }
}
