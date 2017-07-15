<?php
// src/NAO/ProgrammesBundle/Form/ContactReqType.php

namespace NAO\ProgrammesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactReqType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, array(
                'label' => 'Nom*',
                'attr' => ['placeholder' => 'Votre nom',
                'class' => 'nom']))
            ->add('prenom', TextType::class, array(
                'label' => 'Prenom*',
                'attr' => ['placeholder' => 'Votre prénom',
                'class' => 'prenom']))
            ->add('email', EmailType::class, array(
                'label' => 'Email*',
                'attr' => ['placeholder' => 'Votre E-mail',
                'class' => 'email']))
            ->add('sujet', TextType::class, array(
                'label' => 'Sujet*',
                'attr' => ['placeholder' => 'Sujet',
                'class' => 'sujet']))
            ->add('message', TextareaType::class, array(
                'label' => 'Message*',
                'attr' => ['placeholder' => 'Votre message',
                'class' => 'message']));
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NAO\ProgrammesBundle\Entity\ContactReq'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'nao_programmesbundle_contactreq';
    }

}