<?php

namespace NAO\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Gregwar\CaptchaBundle\Type\CaptchaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class MdpType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('password', TextType::class, array(
                'label' => 'Mot de passe'))
            ->add('captcha', CaptchaType::class)
            ->add('Supprimer le compte', SubmitType::class);
        ;
    }
}