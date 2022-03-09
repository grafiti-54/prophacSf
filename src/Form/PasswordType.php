<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Gregwar\CaptchaBundle\Type\CaptchaType;

class UserPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => "Saisir le mot de passe actuel"
                    ],
                    'label' => 'Mot de passe',
                    'label_attr' => ['class' => 'form-label text-white mt-4',]
                ],
                'second_options' => [
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => "Confirmer le mot de passe actuel"
                    ],
                    'label' => 'Confirmation du mot de passe',
                    'label_attr' => ['class' => 'form-label text-white mt-4',]
                ],
                'invalid_message' => 'Les mots de passe ne correspondent pas.'
            ])
            ->add('newPassword', PasswordType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Saisir le nouveau mot de passe"
                ],
                'label' => 'Nouveau mot de passe',
                'label_attr' => ['class' => 'form-label mt-4 text-white'],
                'constraints' => [new Assert\NotBlank()]
            ])
            ->add('captcha', CaptchaType::class, array(
                'width' => 200,
                'height' => 120,
                'length' => 4,
                'invalid_message' => "Captcha incorrect",
                'quality' => 100,
                'label' => ' ',
                'label_attr' => ['class' => 'text-white mb-3'],
                'background_color' => [255, 255, 255],
                'max_front_lines' => 1,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Saisir le captcha"
                ],
                // "reload" => "Changer"
            ))
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn text-white btn-danger mt-4'
                ],
                'label' => 'Changer le mot de passe'
            ]);
    }
}
