<?php

namespace App\Form;

use App\Entity\Equipements;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Departement;


class EquipementsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('typeequipement')
            ->add('nomequipement')
            ->add('detailequipement')
            ->add('zoneequipement')
            ->add('etatequipement')
            ->add('idDepartement',EntityType::class,['class' => Departement::class,
            'choice_label' => 'nomDepartement'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Equipements::class,
        ]);
    }
}
