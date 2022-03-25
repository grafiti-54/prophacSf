<?php

namespace App\Form;

use App\Entity\Articles;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File as ConstraintsFile;

class ArticlesType extends AbstractType
{
    /**
     * Constructeur du formulaire reservé pour la création d'un article par un collaborateur qui n'as pas le role redacteur
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TypeTextType::class, [
                'label' => "Titre de l'article",
            ])
            ->add('contenu', CKEditorType::class, [
                'help_html' => true,
                'label' => "Saisir le texte de l'article",
                'attr' => [
                    'cols' =>'5',
                    'rows' => '15',
                ]
            ])
            ->add('createdDate', DateType::class, [
                'label' => "Date de création de l'article",
            ])
            ->add('illustration', FileType::class, [
                'label' => "Image d'illustration pour l'article ",
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
                    ]),
                ],
            ])
            ->add('titreIllustration')
            ->add('legendeIllustration')
            
            
            // ->add('collaborateur')
            // ->add('images')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
        ]);
    }
}

