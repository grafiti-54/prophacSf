<?php
namespace App\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => "Nom / Société *",
                    'rows' => 6,
                    'class' => 'w-75',
                ],
            ])
            ->add('email',EmailType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => "Votre adresse e-mail * ",
                    'rows' => 6,
                    'class' => 'w-75',
                ],
            ])
            ->add('sujet', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => "Indiquer le sujet de votre message *",
                    'class' => 'w-75'
                ],
                'label' => "Sujet",
                'label_attr' => ['class' => 'form-label',]
            ])
            ->add('message', TextareaType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => "Saisir votre message ici *",
                    'rows' => 6,
                ],
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
        ]);
    }
}
