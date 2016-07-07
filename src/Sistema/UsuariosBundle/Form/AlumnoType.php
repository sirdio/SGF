<?php

namespace Sistema\UsuariosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AlumnoType extends AbstractType
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
                    'invalid_message' => 'Las dos contraseñas deben coincidir',
                     'options' => array('label' => 'Contraseña:')))
             ->add('tipou', 'entity', array(
                'class' => 'Sistema\UsuariosBundle\Entity\TipoUsuario',
                'property' => 'Consulta',
                'label' => 'Tipo de Usuario',
                'required' => true,
                'empty_value' => 'Seleccionar Usuario'
              ))
            ->add('nroLU')
            ->add('anioIng')
//            ->add('nrocuenta')
//            ->add('saldoactual')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sistema\UsuariosBundle\Entity\Alumno'
        ));
    }

    public function getName()
    {
        return 'sistema_usuariosbundle_alumnotype';
    }
}
?>
