<?php

namespace App\Form;

use App\Entity\Compagnie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompagnieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Code_IATA')
            ->add('NomCom')
            ->add('Link')
            ->add('Pays')
            ->add('Number')
            ->add('Siege')
            ->add('AeBase')
            ->add('PassagerNum')
            ->add('Description')
            ->add('images', FileType::class , [
                'label' => false,
                'multiple'=> true,
                'mapped' => false,
                'required'=> false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Compagnie::class,
        ]);
    }
}
