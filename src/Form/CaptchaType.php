<?php

namespace App\Form;

use Gregwar\CaptchaBundle\Type\CaptchaType as TypeCaptchaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CaptchaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('captcha', TypeCaptchaType::class, array(
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
        ));
    }
}