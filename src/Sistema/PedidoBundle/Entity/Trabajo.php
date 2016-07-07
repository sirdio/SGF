<?php

namespace Sistema\PedidoBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Estados
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Sistema\PedidoBundle\Entity\TrabajoRepository")
 */
class Trabajo
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="Sistema\UsuariosBundle\Entity\Empleado")
     * @ORM\JoinColumn(name="empleadoid", referencedColumnName="id")
     */
    private $empleado;

    /**
     * @ORM\OneToOne(targetEntity="Pedidocab")
     * @ORM\JoinColumn(name="pedidocabid", referencedColumnName="id")
     */
    private $pedidocab;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set empleado
     *
     * @param \Sistema\UsuariosBundle\Entity\Empleado $empleado
     * @return Trabajo
     */
    public function setEmpleado(\Sistema\UsuariosBundle\Entity\Empleado $empleado = null)
    {
        $this->empleado = $empleado;
    
        return $this;
    }

    /**
     * Get empleado
     *
     * @return \Sistema\UsuariosBundle\Entity\Empleado 
     */
    public function getEmpleado()
    {
        return $this->empleado;
    }

    /**
     * Set pedidocab
     *
     * @param \Sistema\PedidoBundle\Entity\Pedidocab $pedidocab
     * @return Trabajo
     */
    public function setPedidocab(\Sistema\PedidoBundle\Entity\Pedidocab $pedidocab = null)
    {
        $this->pedidocab = $pedidocab;
    
        return $this;
    }

    /**
     * Get pedidocab
     *
     * @return \Sistema\PedidoBundle\Entity\Pedidocab 
     */
    public function getPedidocab()
    {
        return $this->pedidocab;
    }
}