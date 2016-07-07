<?php
namespace Sistema\PedidoBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;


/**
 * Pagos
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Sistema\PedidoBundle\Entity\PagosRepository")
 */
class Pagos 
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
    * @ORM\Column(name="fechapago", type="string", length=10)
    * @Assert\NotBlank
    */   
    private $fechapago;
    
    /**
    * @ORM\Column(name="descripcion", type="string", length=200)
    * @Assert\NotBlank
    */    
    private $descripcion;

    /**
    * @ORM\Column(name="importe",type="decimal", scale=2)
    * @Assert\NotBlank
    */
    private $importe;
    
     /**
     *
     * @ORM\Column(name="estadopago", type="integer")
     */
    private $estadopago;  
    


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
     * Set fechapago
     *
     * @param string $fechapago
     * @return Pagos
     */
    public function setFechapago($fechapago)
    {
        $this->fechapago = $fechapago;
    
        return $this;
    }

    /**
     * Get fechapago
     *
     * @return string 
     */
    public function getFechapago()
    {
        return $this->fechapago;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Pagos
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
     * Set importe
     *
     * @param float $importe
     * @return Pagos
     */
    public function setImporte($importe)
    {
        $this->importe = $importe;
    
        return $this;
    }

    /**
     * Get importe
     *
     * @return float 
     */
    public function getImporte()
    {
        return $this->importe;
    }

    /**
     * Set estadopago
     *
     * @param integer $estadopago
     * @return Pagos
     */
    public function setEstadopago($estadopago)
    {
        $this->estadopago = $estadopago;
    
        return $this;
    }

    /**
     * Get estadopago
     *
     * @return integer 
     */
    public function getEstadopago()
    {
        return $this->estadopago;
    }
}