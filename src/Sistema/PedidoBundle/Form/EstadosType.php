<?php
namespace Sistema\PedidoBundle\form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EstadosType extends AbstractType {
 public function buildForm(FormBuilderInterface $builder, array $options)
    {
            $builder
            ->add('Estados', 'entity', array(
                'class' => 'Sistema\PedidoBundle\Entity\Estados',
                'property' => 'estadonom',
                'label' => 'Estado del pedido',
                'required' => false,
                'empty_value' => 'Seleccionar estado'))
            ;
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sistema\PedidoBundle\Entity\Estados'
        ));
    }

    public function getName()
    {
        return 'Sistema_pedidobundle_estadotype';
    }
}
?>
