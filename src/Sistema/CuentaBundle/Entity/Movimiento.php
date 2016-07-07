<?php

namespace Sistema\CuentaBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Movimiento
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Sistema\CuentaBundle\Entity\MovimientoRepository")
 */
class Movimiento 
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
     *
     * @ORM\Column(name="nrocuenta", type="integer", nullable=true)
     * @Assert\NotBlank
     */    
     private $nrocuenta;

     /**
    * @ORM\Column(name="fecha", type="string", length=10, nullable=true)
    * @Assert\NotBlank
    */   
    private $fecha;  
    
    
    /**
    * @var string
    *
    * @ORM\Column(name="descripcion", type="string", length=200, nullable=true)
    * @Assert\NotBlank
    */        
    private $descripcion;
    /**
    * @var string
    *
    * @ORM\Column(name="operacion", type="string", length=10, nullable=true)
    * @Assert\NotBlank 
    */            
    private $operacion;

    /**
    * @ORM\Column(name="monto",type="decimal", scale=2, nullable=true)
    * @Assert\NotBlank
    */
    private $monto;
    
    /**
    * @ORM\Column(name="saldopost",type="decimal", scale=2, nullable=true)
    * @Assert\NotBlank
    */
    private $saldopost;    
    
    
    
    
    
    

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
     * Set nrocuenta
     *
     * @param integer $nrocuenta
     * @return Movimiento
     */
    public function setNrocuenta($nrocuenta)
    {
        $this->nrocuenta = $nrocuenta;
    
        return $this;
    }

    /**
     * Get nrocuenta
     *
     * @return integer 
     */
    public function getNrocuenta()
    {
        return $this->nrocuenta;
    }

    /**
     * Set fecha
     *
     * @param string $fecha
     * @return Movimiento
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    
        return $this;
    }

    /**
     * Get fecha
     *
     * @return string 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Movimiento
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    
        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set operacion
     *
     * @param string $operacion
     * @return Movimiento
     */
    public function setOperacion($operacion)
    {
        $this->operacion = $operacion;
    
        return $this;
    }

    /**
     * Get operacion
     *
     * @return string 
     */
    public function getOperacion()
    {
        return $this->operacion;
    }

    /**
     * Set monto
     *
     * @param float $monto
     * @return Movimiento
     */
    public function setMonto($monto)
    {
        $this->monto = $monto;
    
        return $this;
    }

    /**
     * Get monto
     *
     * @return float 
     */
    public function getMonto()
    {
        return $this->monto;
    }

    /**
     * Set saldopost
     *
     * @param float $saldopost
     * @return Movimiento
     */
    public function setSaldopost($saldopost)
    {
        $this->saldopost = $saldopost;
    
        return $this;
    }

    /**
     * Get saldopost
     *
     * @return float 
     */
    public function getSaldopost()
    {
        return $this->saldopost;
    }
}