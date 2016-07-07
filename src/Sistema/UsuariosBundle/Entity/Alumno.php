<?php


namespace Sistema\UsuariosBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="Alumno")
 * @ORM\Entity(repositoryClass="Sistema\UsuariosBundle\Entity\AlumnoRepository")
 * 
 * 
 */
class Alumno extends Usuario
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
     * @var integer
     *
     * @ORM\Column(name="nroLU", type="string", length=5)
     * @Assert\NotNull(message="Debe completar el campo libreta universitaria.")
     */    
     private $nroLU;
     /**
     * @var integer
     *
     * @ORM\Column(name="anioIng", type="string", length=4)
     * @Assert\NotNull(message="Debe completar el campo año de ingreso.")
     */    
     private $anioIng;

     /**
     *
     * @ORM\Column(name="nrocuenta", type="integer", nullable=true)
     */    
     private $nrocuenta;
     /**
     *
     * @ORM\Column(name="saldoactual", type="decimal", scale=2, nullable=true)
     */    
     private $saldoactual;

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
     * Set nroLU
     *
     * @param string $nroLU
     * @return Alumno
     */
    public function setNroLU($nroLU)
    {
        $this->nroLU = $nroLU;
    
        return $this;
    }

    /**
     * Get nroLU
     *
     * @return string 
     */
    public function getNroLU()
    {
        return $this->nroLU;
    }

    /**
     * Set anioIng
     *
     * @param string $anioIng
     * @return Alumno
     */
    public function setAnioIng($anioIng)
    {
        $this->anioIng = $anioIng;
    
        return $this;
    }

    /**
     * Get anioIng
     *
     * @return string 
     */
    public function getAnioIng()
    {
        return $this->anioIng;
    }

    /**
     * Set nrocuenta
     *
     * @param integer $nrocuenta
     * @return Alumno
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
     * Set saldoactual
     *
     * @param float $saldoactual
     * @return Alumno
     */
    public function setSaldoactual($saldoactual)
    {
        $this->saldoactual = $saldoactual;
    
        return $this;
    }

    /**
     * Get saldoactual
     *
     * @return float 
     */
    public function getSaldoactual()
    {
        return $this->saldoactual;
    }
    
//    public function __toString()
//    {
//        return $this->getId();
//    }
}