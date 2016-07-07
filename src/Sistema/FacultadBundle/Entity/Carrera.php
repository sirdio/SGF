<?php
/**
 * @author Siedio
 */
namespace Sistema\FacultadBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
/**
 * @ORM\Entity(repositoryClass="Sistema\FacultadBundle\Entity\CarreraRepository")
 * @ORM\Table(name="Carrera")
 */
class Carrera {
     /**
     * @var integer
     *
     * @ORM\Column(name="Carr_Codigo", type="integer")
     *@ORM\id
     * @Assert\NotNull(message="Debe escribir un titulo")
     */
    private $Carr_Codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="Carr_Nombre", type="string", length=255)
     * @Assert\NotNull(message="Debe escribir un titulo")
     */
    private $Carr_Nombre;

     /**
     * @ORM\ManyToOne(targetEntity="Facultad", inversedBy="Carreras")
     * @ORM\JoinColumn(name="Fac_Codigo", referencedColumnName="Fac_Codigo")
     */
    protected $Facultad;
    
     /**
     * @ORM\ManyToMany(targetEntity="Materia")
     * @ORM\JoinTable(name="CarreraMateria",
     *     joinColumns={@ORM\JoinColumn(name="Carr_id", referencedColumnName="Carr_Codigo")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="Mat_id", referencedColumnName="Mat_Codigo")}
     * )
     */
    protected $CarreraMaterias;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->CarreraMaterias = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set Carr_Codigo
     *
     * @param integer $carrCodigo
     * @return Carrera
     */
    public function setCarrCodigo($carrCodigo)
    {
        $this->Carr_Codigo = $carrCodigo;
    
        return $this;
    }

    /**
     * Get Carr_Codigo
     *
     * @return integer 
     */
    public function getCarrCodigo()
    {
        return $this->Carr_Codigo;
    }

    /**
     * Set Carr_Nombre
     *
     * @param string $carrNombre
     * @return Carrera
     */
    public function setCarrNombre($carrNombre)
    {
        $this->Carr_Nombre = $carrNombre;
    
        return $this;
    }

    /**
     * Get Carr_Nombre
     *
     * @return string 
     */
    public function getCarrNombre()
    {
        return $this->Carr_Nombre;
    }

    /**
     * Set Facultad
     *
     * @param \Sistema\FacultadBundle\Entity\Facultad $facultad
     * @return Carrera
     */
    public function setFacultad(\Sistema\FacultadBundle\Entity\Facultad $facultad = null)
    {
        $this->Facultad = $facultad;
    
        return $this;
    }

    /**
     * Get Facultad
     *
     * @return \Sistema\FacultadBundle\Entity\Facultad 
     */
    public function getFacultad()
    {
        return $this->Facultad;
    }

    /**
     * Add CarreraMaterias
     *
     * @param \Sistema\FacultadBundle\Entity\Materia $carreraMaterias
     * @return Carrera
     */
    public function addCarreraMateria(\Sistema\FacultadBundle\Entity\Materia $carreraMaterias)
    {
        $this->CarreraMaterias[] = $carreraMaterias;
    
        return $this;
    }

    /**
     * Remove CarreraMaterias
     *
     * @param \Sistema\FacultadBundle\Entity\Materia $carreraMaterias
     */
    public function removeCarreraMateria(\Sistema\FacultadBundle\Entity\Materia $carreraMaterias)
    {
        $this->CarreraMaterias->removeElement($carreraMaterias);
    }

    /**
     * Get CarreraMaterias
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCarreraMaterias()
    {
        return $this->CarreraMaterias;
    }
    
    public function __toString()
    {
        return $this->getCarrNombre();
    }
}