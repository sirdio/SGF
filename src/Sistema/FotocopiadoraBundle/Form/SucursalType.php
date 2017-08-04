<?php

namespace Sistema\FotocopiadoraBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SucursalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('SucNomb')
            ->add('SucDom')
            ->add('SucTel')
            ->add('SucEmail')   
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sistema\FotocopiadoraBundle\Entity\Sucursal'
        ));
    }

    public function getName()
    {
        return 'sistema_fotocopiadorabundle_sucursaltype';
    }
}
