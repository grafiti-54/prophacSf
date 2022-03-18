<?php

namespace App\Form;

use App\Entity\Collaborateurs;
use App\Entity\Departements;
use App\Entity\Partenaires;
use App\Entity\Produits;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File as ConstraintsFile;

class DepartementsType extends AbstractType
{
    /**
     * Constructeur du formulaire reservé pour la création et modification d'un département de la société
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class,[
                'label' => "Saisir le nom du nouveau département"
            ])
            ->add('logo', FileType::class,[
                'label' => 'Image du departement',
                'required' => false,
                'mapped' => false, 
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
            ->add('Collaborateur', EntityType::class, [
                'required' => false,
                'class' => Collaborateurs::class,
                'label' => "Liste des collaborateurs appartenants à ce département",
                'expanded' =>true,
                'multiple' => true,
                'mapped' => true,
                'help' => "Ajout ou modifications des collaborateurs appartenants à ce département",
                'choice_label' => function(?Collaborateurs $collaborateur) {
                            return $collaborateur ? $collaborateur->getNom()." ".$collaborateur->getPrenom() : '';
                        },
                
            ])
            // ->add('produit', EntityType::class, [
            //     'disabled' =>true,
            //     'required' => false,
            //     'class' => Produits::class,
            //     'label' => "Liste des produits qui appartiennent à ce département",
            //     'expanded' =>true,
            //     'multiple' => true,
            //     'mapped' => true,
            //     'help' => "Modifications des produits appartenant à ce département ",
                
            // ])
            // ->add('partenaires', EntityType::class, [
            //     'disabled' =>true,
            //     'required' => false,
            //     'class' => Partenaires::class,
            //     'label' => "Liste des partenaires qui appartiennent à ce département",
            //     'expanded' =>true,
            //     'multiple' => true,
            //     'mapped' => true,
            //     'help' => "Modifications des partenaires appartenant à ce département ",
                
            // ])
            ;
        }
    
        public function configureOptions(OptionsResolver $resolver): void
        {
            $resolver->setDefaults([
                'data_class' => Departements::class,
            ]);
        }
    }















            // ->add('Collaborateur', EntityType::class, [
            //     'required' => false,
            //     'class' => Collaborateurs::class,
            //     'choice_label' => 'nom',
            //     'multiple' => true,
            //     // 'mapped' => true,
            // ])

            

            // ->add('Collaborateur', ChoiceType::class, [
            //     'choices' => [
            //         new Collaborateurs('Cat1')   
            //     ],
            //     // "name" is a property path, meaning Symfony will look for a public
            //     // property or a public method like "getName()" to define the input
            //     // string value that will be submitted by the form
            //     // 'choice_value' => 'nom',
            //     // a callback to return the label for a given choice
            //     // if a placeholder is used, its empty value (null) may be passed but
            //     // its label is defined by its own "placeholder" option
            //     'choice_label' => function(?Collaborateurs $collaborateur) {
            //         return $collaborateur ? strtoupper($collaborateur->getNom()) : '';
            //     },
            //     // returns the html attributes for each option input (may be radio/checkbox)
            //     'choice_attr' => function(?Collaborateurs $collaborateur) {
            //         return $collaborateur ? ['class' => 'category_'.strtolower($collaborateur->getNom())] : [];
            //     },
            //     // every option can use a string property path or any callable that get
            //     // passed each choice as argument, but it may not be needed
            //     // 'group_by' => function() {
            //     //     // randomly assign things into 2 groups
            //     //     return rand(0, 1) == 1 ? 'Group A' : 'Group B';
            //     // },
            //     // a callback to return whether a category is preferred
            //     // 'preferred_choices' => function(?Collaborateurs $collaborateur) {
            //     //     return $collaborateur && 100 < $collaborateur->getCollaborateursCounts();
            //     // },
            // ]);



            // ->add('collaborateur',CollectionType::class , [
            //     'label' => 'Liste des collaborateurs de ce département',
            //     'attr' => [
            //         'class' => 'form-control',
            //     ],   
            // ])
            // ->add('produit')
            // ->add('partenaires')
        
