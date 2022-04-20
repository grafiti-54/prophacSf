<?php

namespace App\Form;

use App\Entity\Departements;
use App\Entity\Partenaires;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File as ConstraintsFile;

class PartenairesType extends AbstractType
{
    /**
     * Constructeur du formulaire reservé pour la modification et la création d'un partenaire
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('siteInternet')
            ->add('departement', EntityType::class, [
                'required' => false,
                'class' => Departements::class,
                'label' => "Liste des départements en relation avec ce partenaire",
                'expanded' =>true,
                'multiple' => true,
                'mapped' => true,
                'help' => "Modifications des collaborateurs appartenant à ce département ", 
            ])
            ->add('logo', FileType::class,[
                'label' => 'Image du partenaire',
                'required' => false,
                'mapped' => false, 
                'constraints' => [
                    new ConstraintsFile([
                        'maxSize' => '10240k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',   
                        ],
                        'mimeTypesMessage' => 'Merci d\'inserer un fichier jpeg ou png',
                    ])
                ]
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Partenaires::class,
        ]);
    }
}
