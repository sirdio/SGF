<?php

/**
 *
 * @author Siedio
 */
namespace Sistema\FacultadBundle\form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
class CarreraType extends AbstractType {
 public function buildForm(FormBuilderInterface $builder, array $options)
    {
            $builder
            ->add('Carr_Codigo','text')
            ->add('Carr_Nombre','text')
            ->add('Facultad', 'entity', array(
                'class' => 'Sistema\FacultadBundle\Entity\Facultad',
                'property' => 'Fac_Nombre',
                'label' => 'Facultad',
                'required' => false,
                'empty_value' => 'Seleccionar Facultad'
              ))
            ->add('CarreraMaterias', 'entity', array(
                'class' => 'Sistema\FacultadBundle\Entity\Materia',
                'property' => 'Mat_Nombre',
                'label' => 'Materias',
                'multiple' => true,
                //'size' => 10,
                //'expanded' => true
              ))
        ;
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sistema\FacultadBundle\Entity\Carrera'
        ));
    }

    public function getName()
    {
        return 'Sistema_facultadbundle_carreratype';
    }
    public function __toString()
    {
        return $this->getCarreraMaterias();
    }
}


?>
