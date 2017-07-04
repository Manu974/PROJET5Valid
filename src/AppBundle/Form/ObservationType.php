<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;




class ObservationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('createdAt', DateTimeType::class)
            ->add('department', ChoiceType::class)
            ->add('location')
            ->add('nomVernaculaire', EntityType::class, [
                'class'        => 'AppBundle:Bird',
                'choice_label' => 'nomVern',
                'multiple'     => false,
              ])
            ->add('nomScientifique', EntityType::class, [
                'class'        => 'AppBundle:Bird',
                'choice_label' => 'lb_nom',
                'multiple'     => false,
              ])
            ->add('famille', EntityType::class, [
                'class'        => 'AppBundle:Bird',
                'choice_label' => 'famille',
                'multiple'     => false,
              ])
            ->add('nombreOiseaux', ChoiceType::class)
            ->add('maturite', ChoiceType::class)
            ->add('nidification', CheckboxType::class, [
                'label' => 'nidification',
                'required' => false

                ])
            ->add('comment', TextareaType::class)
            ->add('image', ObservationImageType::class)
            ->add('author')
            ->add('save',      SubmitType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Observation'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_observation';
    }


}
