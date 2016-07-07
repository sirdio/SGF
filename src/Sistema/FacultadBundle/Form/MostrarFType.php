<?php
namespace Sistema\FacultadBundle\form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MostrarFType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
            $builder
                   ->add('Facultad', 'entity', array(
                'class' => 'Sistema\FacultadBundle\Entity\Facultad',
                'property' => 'Fac_Nombre',
                'label' => 'Facultad',
                'required' => false,
                'empty_value' => 'Seleccionar Facultad'))
            
                    ->add('Carrera', 'entity', array(
                'class' => 'Sistema\FacultadBundle\Entity\Carrera',
                'property' => 'Carr_Nombre',
                'label' => 'Carrera',
                'required' => false,
                'empty_value' => 'Seleccionar Carrera'))
            
                   ->add('Materia', 'entity', array(
                'class' => 'Sistema\FacultadBundle\Entity\Materia',
                'property' => 'Mat_Nombre',
                'label' => 'Materia',
                'required' => false,
                'empty_value' => 'Seleccionar Materia'))               
            
            
//            ->add('Cargar','submit')
            
            ;
    }
//    public function setDefaultOptions(OptionsResolverInterface $resolver)
//    {
//        $resolver->setDefaults(array(
////            'data_class' => 'Sistema\FacultadBundle\Entity\Facultad'
//        ));
//    }
    public function getName() {
        return 'Sistema_facultadbundle_mostrarftype';
    }
}

?>
