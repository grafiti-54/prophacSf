<?php

namespace App\Form;

use App\Entity\Collaborateurs;
use App\Entity\Qualifications;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File as ConstraintsFile;

class ProfilType extends AbstractType
{
    /**
     * Constructeur du formulaire réservé aux collaborateurs qui souhaitent modifier leurs données depuis la page de profil
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('photo', FileType::class, [
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
                    ]),
                ],
            ])
            ->add('qualification', EntityType::class, [
                'required' => false,
                'class' => Qualifications::class,
                'expanded' =>true,
                'multiple' => true,
                'mapped' => true,
                'help' => "Selectionner la ou les qualifications de ce collaborateur",
            ])
            ->add('numero')

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Collaborateurs::class,
        ]);
    }
}
