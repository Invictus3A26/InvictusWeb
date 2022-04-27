<?php

namespace App\Form;

use App\Entity\Compagnie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



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
            ->add('images', FileType::class ,

                array(
                    'required'=>false,

                    'attr' => array(
                        'accept' => "image/jpeg, image/png"
                    ),
                    'constraints' => [
                        new File([
                            'maxSize' => '2M',
                            'mimeTypes' => [
                                'image/jpeg',
                                'image/png',
                            ],
                            'mimeTypesMessage' => 'Please upload a JPG or PNG',
                        ])
                    ]
                )
            )
            ->add('color',ColorType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([

            'data_class' => Compagnie::class,
        ]);
    }
}
