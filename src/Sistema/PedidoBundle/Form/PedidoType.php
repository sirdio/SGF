<?php
namespace Sistema\PedidoBundle\form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class PedidoType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
            $builder
            ->add('fechap','date', array(
                   'format'=>'dd-MM-yyyy'))
//            ->add('Estados', 'entity', array(
//                'class' => 'Sistemagf\PedidoBundle\Entity\Estados',
//                'property' => 'estadonom',
//                'label' => 'Estado del pedido',
//                'required' => false,
//                'empty_value' => 'Seleccionar estado'))   
            ->add('estadoid')
//            ->add('total')
            ;
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sistema\PedidoBundle\Entity\Pedidocab'
        ));
    }

    public function getName()
    {
        return 'Sistema_pedidobundle_pedidotype';
    }     
}

?>
