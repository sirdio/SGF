<?php

namespace Sistema\UsuariosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EmpleadoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('apellido')    
            ->add('Email')
            ->add('username')
            ->add('nrocel')
            ->add('password', 'repeated', array(
                    'type' => 'password',
                    'invalid_message' => 'Los campos contraseña deben coincidir.',
                     'options' => array('label' => 'Contraseña:')))
            ->add('tipou', 'entity', array(
                'class' => 'Sistema\UsuariosBundle\Entity\TipoUsuario',
                'property' => 'Name',
                'label' => 'Tipo de Usuario',
                'required' => true,
                'empty_value' => 'Seleccionar Usuario'
              ))   
            ->add('sucid')                
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sistema\UsuariosBundle\Entity\Empleado'
        ));
    }

    public function getName()
    {
        return 'sistema_usuariosbundle_empleadotype';
    }
}

?>
