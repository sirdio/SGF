<?php

namespace Sistema\UsuariosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EmpleadopassType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('password', 'repeated', array(
                    'type' => 'password',
                    'invalid_message' => 'Los campos contraseña deben coincidir',
                     'options' => array('label' => 'Contraseña:')))
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
        return 'sistema_usuariosbundle_empleadopasstype';
    }
}

?>