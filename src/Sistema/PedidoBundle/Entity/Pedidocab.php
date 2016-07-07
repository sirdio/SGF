<?php

namespace Sistema\PedidoBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Pedidocab
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Sistema\PedidoBundle\Entity\PedidocabRepository")
 */
class Pedidocab
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
    * @ORM\Column(name="fecha", type="string", length=10)
    * @Assert\NotBlank
    */   
    private $fechap;    
    
    /**
    * @ORM\Column(name="total",type="decimal", scale=2)
    * @Assert\NotBlank
    */
    private $total;    
    
     /**
     * @ORM\OneToMany(targetEntity="Pedidodet", mappedBy="Pedidocab")
     */
    protected $Pedidodet;

     /**
     * @var integer
     *
     * @ORM\Column(name="estadopag", type="integer")
     */
    private $estadopag;
    
    /**
    * @ORM\Column(name="tipopago", type="integer")
    * @Assert\NotBlank
    */    
    private $tipopago;
    
    
    /**
    * @ORM\ManyToOne(targetEntity="Estados")
    * @ORM\JoinColumn(name="estadosid", referencedColumnName="id")
    */
    private $estados;
    
    /**
    * @ORM\ManyToOne(targetEntity="\Sistema\FotocopiadoraBundle\Entity\Sucursal")
    * @ORM\JoinColumn(name="sucursalesid", referencedColumnName="id")
    */
    private $sucursal;    

    /**
    * @ORM\ManyToOne(targetEntity="\Sistema\UsuariosBundle\Entity\Alumno")
    * @ORM\JoinColumn(name="alumnoid", referencedColumnName="id")
    */
    private $usuarioalu;     
    
     /**
     * @var integer
     *
     * @ORM\Column(name="entregaest", type="integer")
     */
    private $entregaest;    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->Pedidodet = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * Set fechap
     *
     * @param string $fechap
     * @return Pedidocab
     */
    public function setFechap($fechap)
    {
        $this->fechap = $fechap;
    
        return $this;
    }

    /**
     * Get fechap
     *
     * @return string 
     */
    public function getFechap()
    {
        return $this->fechap;
    }

    /**
     * Set total
     *
     * @param float $total
     * @return Pedidocab
     */
    public function setTotal($total)
    {
        $this->total = $total;
    
        return $this;
    }

    /**
     * Get total
     *
     * @return float 
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Add Pedidodet
     *
     * @param \Sistema\PedidoBundle\Entity\Pedidodet $pedidodet
     * @return Pedidocab
     */
    public function addPedidodet(\Sistema\PedidoBundle\Entity\Pedidodet $pedidodet)
    {
        $this->Pedidodet[] = $pedidodet;
    
        return $this;
    }

    /**
     * Remove Pedidodet
     *
     * @param \Sistema\PedidoBundle\Entity\Pedidodet $pedidodet
     */
    public function removePedidodet(\Sistema\PedidoBundle\Entity\Pedidodet $pedidodet)
    {
        $this->Pedidodet->removeElement($pedidodet);
    }

    /**
     * Get Pedidodet
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPedidodet()
    {
        return $this->Pedidodet;
    }

    public function __toString()
    {
        return $this->getFechap();
    }
    

    /**
     * Set estadopag
     *
     * @param integer $estadopag
     * @return Pedidocab
     */
    public function setEstadopag($estadopag)
    {
        $this->estadopag = $estadopag;
    
        return $this;
    }

    /**
     * Get estadopag
     *
     * @return integer 
     */
    public function getEstadopag()
    {
        return $this->estadopag;
    }

    /**
     * Set tipopago
     *
     * @param integer $tipopago
     * @return Pedidocab
     */
    public function setTipopago($tipopago)
    {
        $this->tipopago = $tipopago;
    
        return $this;
    }

    /**
     * Get tipopago
     *
     * @return integer 
     */
    public function getTipopago()
    {
        return $this->tipopago;
    }

    /**
     * Set estados
     *
     * @param \Sistema\PedidoBundle\Entity\Estados $estados
     * @return Pedidocab
     */
    public function setEstados(\Sistema\PedidoBundle\Entity\Estados $estados = null)
    {
        $this->estados = $estados;
    
        return $this;
    }

    /**
     * Get estados
     *
     * @return \Sistema\PedidoBundle\Entity\Estados 
     */
    public function getEstados()
    {
        return $this->estados;
    }

    /**
     * Set sucursal
     *
     * @param \Sistema\FotocopiadoraBundle\Entity\Sucursal $sucursal
     * @return Pedidocab
     */
    public function setSucursal(\Sistema\FotocopiadoraBundle\Entity\Sucursal $sucursal = null)
    {
        $this->sucursal = $sucursal;
    
        return $this;
    }

    /**
     * Get sucursal
     *
     * @return \Sistema\FotocopiadoraBundle\Entity\Sucursal 
     */
    public function getSucursal()
    {
        return $this->sucursal;
    }

    /**
     * Set usuarioalu
     *
     * @param \Sistema\UsuariosBundle\Entity\Alumno $usuarioalu
     * @return Pedidocab
     */
    public function setUsuarioalu(\Sistema\UsuariosBundle\Entity\Alumno $usuarioalu = null)
    {
        $this->usuarioalu = $usuarioalu;
    
        return $this;
    }

    /**
     * Get usuarioalu
     *
     * @return \Sistema\UsuariosBundle\Entity\Alumno 
     */
    public function getUsuarioalu()
    {
        return $this->usuarioalu;
    }

    /**
     * Set entregaest
     *
     * @param integer $entregaest
     * @return Pedidocab
     */
    public function setEntregaest($entregaest)
    {
        $this->entregaest = $entregaest;
    
        return $this;
    }

    /**
     * Get entregaest
     *
     * @return integer 
     */
    public function getEntregaest()
    {
        return $this->entregaest;
    }
}