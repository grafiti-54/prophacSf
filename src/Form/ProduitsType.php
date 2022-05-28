<?php

namespace App\Form;

use App\Entity\Partenaires;
use App\Entity\Produits;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File as ConstraintsFile;

class ProduitsType extends AbstractType
{
    /**
     * Constructeur du formulaire pour la création et la modification d'un produit
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('description')
            ->add('photo', FileType::class,[
                'label' => 'Image du produit',
                'required' => false,
                'mapped' => false, 
                'constraints' => [
                    new ConstraintsFile([
                        'maxSize' => '10240k', // Taille maxi de l'image
                        'mimeTypes' => [ // Formats d'image autorisé
                            'image/jpeg',
                            'image/png',    
                        ],
                        'mimeTypesMessage' => 'Veuillez insérer un jpeg ou un png',
                    ])
                ]
            ])
            ->add('lien')
            ->add('departement')
            ->add('partenaire', EntityType::class, [
                'label' => 'Partenaire du produit',
                'required' => false,
                'class' => Partenaires::class,
                'multiple' => false,
            ])
            ->add('prioritaire', CheckboxType::class, [
                'label' => "Afficher ce produit sur la page d'accueil du site ?",
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produits::class,
        ]);
    }
}
