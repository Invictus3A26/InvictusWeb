<?php

namespace App\Form;

use App\Entity\Avion;
use App\Entity\Compagnie;
use App\Entity\Escale;
use App\Entity\Vols;
use App\Entity\Airport;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class VolsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numVol')
            ->add('dateDepartVol')
            ->add('dateArriveVol')
            ->add('heureDepartVol')
            ->add('heureArriveVol')
            ->add('idAeroport',EntityType::class,['class' => Airport::class,
            'choice_label' => 'nom_aeroport'])
            ->add('typeAvion',EntityType::class,['class' => Avion::class,
            'choice_label' => 'CodeAvion'])
            ->add('typeVol',ChoiceType::class,array(
                'choices' => array(
                    'Depart'=> "Depart",
                    'Arrivé'=>"Arrivé",
                )
            ))
            ->add('idEscale',EntityType::class,['class' => Escale::class,
            'choice_label' => 'id_escale'])
            ->add('idComp',EntityType::class,['class' => Compagnie::class,
            'choice_label' => 'NomCom'])
            ->add('nombrepassagerVol')
            ->add('dureeRetardVol')
            ->add('annulationVol')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vols::class,
        ]);
    }
}
