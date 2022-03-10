<?php

namespace App\Form;

use App\Entity\Collaborateurs;
use App\Entity\Departements;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File as ConstraintsFile;

class DepartementsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('logo', FileType::class,[
                'label' => 'Image du collaborateur',
                'required' => false,
                'mapped' => false, // n'est pas lié a la base de donnée
                'constraints' => [
                    new ConstraintsFile([
                        'maxSize' => '10240k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Veuiller inserer un jpeg ou un png',
                    ])
                ]
            ])
            // ->add('produit')
            // ->add('partenaires')
            ->add('Collaborateur', EntityType::class, [
                'required' => false,
                'class' => Collaborateurs::class,
                'multiple' => true,
                'mapped' => true,
            ])
            // ->add('collaborateur',CollectionType::class , [
            //     'label' => 'Liste des collaborateurs de ce département',
            //     'attr' => [
            //         'class' => 'form-control',
            //     ],   
            // ])
            // ->add('produit')
            // ->add('partenaires')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Departements::class,
        ]);
    }
}
