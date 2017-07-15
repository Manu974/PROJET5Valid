<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class BirdType extends AbstractType
{
    /**
    * {@inheritdoc}
    */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('famille', EntityType::class, [
                'class'        => 'AppBundle:Bird',
                'choice_label' => 'famille',
                'multiple'     => false,
            ])
            ->add('lb_nom', EntityType::class, [
                'class'        => 'AppBundle:Bird',
                'choice_label' => 'lb_nom',
                'multiple'     => false,
            ])
            ->add('nomVern', EntityType::class, [
                'class'        => 'AppBundle:Bird',
                'choice_label' => 'nomVern',
                'multiple'     => false,
            ]);
    }

    /**
    * {@inheritdoc}
    */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Bird'
        ]);
    }

    /**
    * {@inheritdoc}
    */
    public function getBlockPrefix()
    {
        return 'appbundle_bird';
    }


}
