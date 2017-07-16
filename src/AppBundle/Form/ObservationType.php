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
use Gregwar\CaptchaBundle\Type\CaptchaType;
use AppBundle\Repository\BirdRepository;

class ObservationType extends AbstractType
{
    /**
    * {@inheritdoc}
    */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('createdAt', DateTimeType::class, [
                'label' => 'Date et Heure'
            ])
            ->add('department', EntityType::class, [
                'class'        => 'AppBundle:Departement',
                'label'        => 'Département',
                'choice_label' => 'code',
                'multiple'     => false,
            ])
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
            ->add('nombreOiseaux', ChoiceType::class, [
                'choices' => [
                    'Seul' => 'Seul',
                    'Couple' => 'Couple',
                    'Famille' => 'Famille',
                    'Groupe' => 'Groupe',
                ],
            ])
            ->add('maturite', ChoiceType::class, [
                'choices' => [
                    'Poussin' => 'Poussin',
                    'Juvénile' => 'Juvénile',
                    'Immature' => 'Immature',
                    'Sub-adulte' => 'Sub-adulte',
                    'Adulte' => 'Adulte',
                ],
            ])
            ->add('nidification', CheckboxType::class, [
                'label' => 'Nidification',
                'attr'  => [
                    'class' => 'nidification-checkbox'
                ],
                'required' => false
            ])
            ->add('comment', TextareaType::class)
            ->add('author', TextType::class, ['required' => false,])
            ->add('captcha', CaptchaType::class)
            ->add('Sauvegarder',      SubmitType::class);

    }

    /**
    * {@inheritdoc}
    */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Observation'
        ]);
    }

    /**
    * {@inheritdoc}
    */
    public function getBlockPrefix()
    {
        return 'appbundle_observation';
    }

}
