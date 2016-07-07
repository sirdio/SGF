<?php

namespace Sistema\CuentaBundle\form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MovimientoType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder
            ->add('nrocuenta')
            ->add('fecha')
            ->add('descripcion')    
            ->add('operacion')
            ->add('monto')    
            ->add('saldopost')          
        ;
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver) 
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sistema\CuentaBundle\Entity\Movimiento'
        ));  
    }
    public function getName() 
    {
        return 'sistema_cuentabundle_movimientotype';        
    }
}
?>