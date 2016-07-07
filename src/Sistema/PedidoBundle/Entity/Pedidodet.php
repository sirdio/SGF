<?php

namespace Sistema\PedidoBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Pedidodet
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Sistema\PedidoBundle\Entity\PedidodetRepository")
 */
class Pedidodet
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
     * @ORM\ManyToOne(targetEntity="Pedidocab", inversedBy="Pedidodet")
     * @ORM\JoinColumn(name="idcab", referencedColumnName="id")
     */
    protected $Pedidocab;
        
     /**
     * 
     * @ORM\ManyToOne(targetEntity="Sistema\FotocopiadoraBundle\Entity\Apunte", inversedBy="Pedidodet")
     * @ORM\JoinColumn(name="apunteid", referencedColumnName="id")
     */
    protected $apunte;
    
    
    /**
    * @ORM\Column(name="subtotal",type="decimal", scale=2)
    */
    private $subtotal;    
    
    
   
    

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
     * Set subtotal
     *
     * @param float $subtotal
     * @return Pedidodet
     */
    public function setSubtotal($subtotal)
    {
        $this->subtotal = $subtotal;
    
        return $this;
    }

    /**
     * Get subtotal
     *
     * @return float 
     */
    public function getSubtotal()
    {
        return $this->subtotal;
    }

    /**
     * Set Pedidocab
     *
     * @param \Sistema\PedidoBundle\Entity\Pedidocab $pedidocab
     * @return Pedidodet
     */
    public function setPedidocab(\Sistema\PedidoBundle\Entity\Pedidocab $pedidocab = null)
    {
        $this->Pedidocab = $pedidocab;
    
        return $this;
    }

    /**
     * Get Pedidocab
     *
     * @return \Sistema\PedidoBundle\Entity\Pedidocab 
     */
    public function getPedidocab()
    {
        return $this->Pedidocab;
    }

    /**
     * Set apunte
     *
     * @param \Sistema\FotocopiadoraBundle\Entity\Apunte $apunte
     * @return Pedidodet
     */
    public function setApunte(\Sistema\FotocopiadoraBundle\Entity\Apunte $apunte = null)
    {
        $this->apunte = $apunte;
    
        return $this;
    }

    /**
     * Get apunte
     *
     * @return \Sistema\FotocopiadoraBundle\Entity\Apunte 
     */
    public function getApunte()
    {
        return $this->apunte;
    }
    
    
}