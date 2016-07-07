<?php

namespace Sistema\FotocopiadoraBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Empleado2Type extends AbstractType
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
            'data_class' => 'Sistema\UsuariosBundle\Entity\Usuario'
        ));
    }

    public function getName()
    {
        return 'sistema_usuariosbundle_usuariotype';
    }
}

?>