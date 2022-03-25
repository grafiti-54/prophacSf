<?php

namespace App\Form;

use App\Entity\Collaborateurs;
use App\Entity\Qualifications;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File as ConstraintsFile;

class CollaborateursType extends AbstractType
{
    /**
     * Constructeur du formulaire reservé pour la modification d'un collaborateur pour l'administrateur
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
            ->add('Roles', ChoiceType::class, [
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'choices' => [
                    'Admin' => 'ROLE_ADMIN',
                    'Redacteur' => 'ROLE_REDACTEUR',
                    'User' => 'ROLE_USER',
                ],
            ])
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
        // Data transformer
        $builder->get('Roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                    // transform the array to a string
                    return count($rolesArray) ? $rolesArray[0] : null;
                },
                function ($rolesString) {
                    // transform the string back to an array
                    return [$rolesString];
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Collaborateurs::class,
        ]);
    }
}








































// RAJOUTER DANS LE $BUILDER SI NECESSAIRE (DEPARTEMENT - QUALIFICATION -MDP (pas conseillé pour mdp et département))

// use App\Entity\Departements;
// use Symfony\Component\Form\Extension\Core\Type\PasswordType;
// use Symfony\Component\Mime\Encoder\EncoderInterface;
// use Symfony\Component\Serializer\Encoder\EncoderInterface as EncoderEncoderInterface;
// use Symfony\Component\Validator\Constraints\Length;
// use Symfony\Component\Validator\Constraints\NotBlank;
// use Symfony\Component\Uid\Uuid;

// ->add('departements', EntityType::class, [
            //     'required' => false,
            //     // 'disabled' => true,
            //     'class' => Departements::class,
            //     'expanded' =>true,
            //     'multiple' => true,
            //     'mapped' => false,
            //     'help' => "Selectionner le ou les départements de ce collaborateur ",
                
            // ])
            // ->add('qualification', EntityType::class, [
            //     'required' => false,
            //     'class' => Qualifications::class,
            //     'mapped' => false,
            //     'choice_value' => function(Qualifications $qualification = null){
            //         if($qualification){
            //             return $qualification->getId();
            //         }
            //     },
            //     'help' => "Selectionner la qualification",
            //     // "choice_label" => function(Qualifications $qualification){
            //     //     return $qualification->getLibelle();

            //     // }
            // ])

            // ->add('password', PasswordType::class, [
            //     // instead of being set onto the object directly,
            //     // this is read and encoded in the controller
            //     'mapped' => false,
            //     'attr' => ['autocomplete' => 'new-password'],
            //     'constraints' => [
            //         new NotBlank([
            //             'message' => 'Please enter a password',
            //         ]),
            //         new Length([
            //             'min' => 5,
            //             'minMessage' => 'Your password should be at least {{ limit }} characters',
            //             // max length allowed by Symfony for security reasons
            //             'max' => 4096,
            //         ]),
            //     ],
            // ])