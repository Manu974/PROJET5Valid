<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BirdType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('regne')->add('phylum')->add('classe')->add('ordre')->add('famille')->add('cdNom')->add('cdTaxsup')->add('cdRef')->add('rang')->add('lbNom')->add('lbAuteur')->add('nomComplet')->add('nomValide')->add('nomVern')->add('nomVernEng')->add('habitat')->add('fr')->add('gf')->add('mar')->add('gua')->add('sm')->add('sb')->add('spm')->add('may')->add('epa')->add('reu')->add('sa')->add('ta')->add('taaf')->add('nc')->add('wf')->add('pf')->add('cli');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Bird'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_bird';
    }


}
