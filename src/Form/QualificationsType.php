<?php

namespace App\Form;

use App\Entity\Qualifications;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QualificationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('libelle')
            ->add('libelle', TextType::class, [
                'attr' => [
                    'placeholder' => "Saisir une nouvelle qualification",
                    'class' => 'w-50 ms-3'
                ],
                'label' => "Nom de la qualification",
                'label_attr' => ['class' => 'form-label mt-4 ms-4',]
            ])
            //->add('collaborateurs')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Qualifications::class,
        ]);
    }
}
