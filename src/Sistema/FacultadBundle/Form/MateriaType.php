<?php

/**
 * Description of MateriaType
 *
 * @author Siedio
 */
namespace Sistema\FacultadBundle\form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MateriaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
            $builder
            ->add('Mat_Codigo','text')
            ->add('Mat_Nombre','text')
        ;
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sistema\FacultadBundle\Entity\Materia'
        ));
    }

    public function getName()
    {
        return 'Sistema_facultadbundle_materiatype';
    }
}

?>
