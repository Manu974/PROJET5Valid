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
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ObservationCarteType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('famille', EntityType::class, [
                    'class'        => 'AppBundle:Bird',
                    'choice_label' => 'famille',
                    'multiple'     => false,
                  ])
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
            ->add('department', EntityType::class, [
                'class'        => 'AppBundle:Departement',
                'choice_label' => 'code',
                'multiple'     => false,
              ])
            ->add('Rechercher',      SubmitType::class);
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
        


}
