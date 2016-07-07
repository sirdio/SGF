<?php

namespace Sistema\FotocopiadoraBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ApunteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
//            ->add('fecha')
            ->add('fecha','date', array(
                    'format'=>'dd-MM-yyyy'))    
                
            ->add('nropag')
            ->add('precio')
            ->add('observacion')
            ->add('facultad_id')
            ->add('carrera_id')
            ->add('materia_id')
            ->add('path','file')
            
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sistema\FotocopiadoraBundle\Entity\Apunte'
        ));
    }

    public function getName()
    {
        return 'sistema_fotocopiadorabundle_apuntetype';
    }
}
