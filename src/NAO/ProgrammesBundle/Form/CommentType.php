<?php

namespace NAO\ProgrammesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', TextType::class, array(
                'attr' => ['placeholder' => 'Nom de l\'auteur',
                'class' => 'nom'],
                'label' => 'Auteur'))
            ->add('comment', TextareaType::class, array(
                'attr' => ['placeholder' => 'Ecrire un commentaire',
                'class' => 'message'],
                'label' => 'Commentaire'));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NAO\ProgrammesBundle\Entity\Comment'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'nao_programmesbundle_comment';
    }

}
