<?php
/**
 * Description of FacultadType
 *
 * @author Siedio
 */
namespace Sistema\FacultadBundle\form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FacultadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
            $builder
            ->add('Fac_Codigo')
            ->add('Fac_Nombre')
        ;
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sistema\FacultadBundle\Entity\Facultad'
        ));
    }

    public function getName()
    {
        return 'Sistema_facultadbundle_facultadtype';
    }
}

?>
