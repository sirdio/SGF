<?php
/** 
 * @author Siedio
 */
namespace Sistema\FacultadBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Facultad
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Sistema\FacultadBundle\Entity\FacultadRepository")
 */
class Facultad {
    /**
    * @var integer
    *
    * @ORM\Column(name="Fac_Codigo", type="integer")
    * @ORM\id
    * @Assert\NotBlank() 
    */
    private $Fac_Codigo;
    
        /**
     * @var string
     * @ORM\Column(name="Fac_Nombre", type="string", length=255)
     */
    private $Fac_Nombre;
    
     /**
     * @ORM\OneToMany(targetEntity="carrera", mappedBy="Facultad")
     */
    protected $carreras;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->carreras = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set Fac_Codigo
     *
     * @param integer $facCodigo
     * @return Facultad
     */
    public function setFacCodigo($facCodigo)
    {
        $this->Fac_Codigo = $facCodigo;
    
        return $this;
    }

    /**
     * Get Fac_Codigo
     *
     * @return integer 
     */
    public function getFacCodigo()
    {
        return $this->Fac_Codigo;
    }

    /**
     * Set Fac_Nombre
     *
     * @param string $facNombre
     * @return Facultad
     */
    public function setFacNombre($facNombre)
    {
        $this->Fac_Nombre = $facNombre;
    
        return $this;
    }

    /**
     * Get Fac_Nombre
     *
     * @return string 
     */
    public function getFacNombre()
    {
        return $this->Fac_Nombre;
    }

    /**
     * Add carreras
     *
     * @param \Sistema\FacultadBundle\Entity\carrera $carreras
     * @return Facultad
     */
    public function addCarrera(\Sistema\FacultadBundle\Entity\carrera $carreras)
    {
        $this->carreras[] = $carreras;
    
        return $this;
    }

    /**
     * Remove carreras
     *
     * @param \Sistema\FacultadBundle\Entity\carrera $carreras
     */
    public function removeCarrera(\Sistema\FacultadBundle\Entity\carrera $carreras)
    {
        $this->carreras->removeElement($carreras);
    }

    /**
     * Get carreras
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCarreras()
    {
        return $this->carreras;
    }
    
    public function __toString()
    {
        return $this->getFacNombre();
    }
}