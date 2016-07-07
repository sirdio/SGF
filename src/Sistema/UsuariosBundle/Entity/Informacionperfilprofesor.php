<?php
 

namespace Sistema\UsuariosBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Pagos
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Sistema\UsuariosBundle\Entity\InformacionperfilprofesorRepository")
 */
class Informacionperfilprofesor 
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
    * @ORM\ManyToOne(targetEntity="Sistema\FacultadBundle\Entity\Facultad")
    * @ORM\JoinColumn(name="facid", referencedColumnName="Fac_Codigo")
    */
    private $facultad;
    
    /**
    * @ORM\ManyToOne(targetEntity="Sistema\FacultadBundle\Entity\Carrera")
    * @ORM\JoinColumn(name="carrid", referencedColumnName="Carr_Codigo")
    */
    private $carrera;

    /**
    * @ORM\ManyToOne(targetEntity="Sistema\FacultadBundle\Entity\Materia")
    * @ORM\JoinColumn(name="matid", referencedColumnName="Mat_Codigo")
    */
    private $materia;  
    
    /**
    * @ORM\ManyToOne(targetEntity="Profesor")
    * @ORM\JoinColumn(name="profesorid", referencedColumnName="id")
    */
    private $usuarioprof; 
    
     /**
     * @var integer     
     * @ORM\Column(name="resolucionnro", type="string", length=15)
     * @Assert\NotNull(message="Debe completar el campo resolucion.")
     */    
     private $nroresolucion;    
     
    /**
    * @ORM\Column(name="fechafinresol", type="string", length=10)
    * 
    */    
    protected $fechafinresol;
    
    /**
    * @ORM\Column(name="is_active", type="boolean")
    */
    private $isActive;
    

  

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
     * Set nroresolucion
     *
     * @param string $nroresolucion
     * @return Informacionperfilprofesor
     */
    public function setNroresolucion($nroresolucion)
    {
        $this->nroresolucion = $nroresolucion;
    
        return $this;
    }

    /**
     * Get nroresolucion
     *
     * @return string 
     */
    public function getNroresolucion()
    {
        return $this->nroresolucion;
    }

    /**
     * Set fechafinresol
     *
     * @param string $fechafinresol
     * @return Informacionperfilprofesor
     */
    public function setFechafinresol($fechafinresol)
    {
        $this->fechafinresol = $fechafinresol;
    
        return $this;
    }

    /**
     * Get fechafinresol
     *
     * @return string 
     */
    public function getFechafinresol()
    {
        return $this->fechafinresol;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Informacionperfilprofesor
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    
        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set facultad
     *
     * @param \Sistema\FacultadBundle\Entity\Facultad $facultad
     * @return Informacionperfilprofesor
     */
    public function setFacultad(\Sistema\FacultadBundle\Entity\Facultad $facultad = null)
    {
        $this->facultad = $facultad;
    
        return $this;
    }

    /**
     * Get facultad
     *
     * @return \Sistema\FacultadBundle\Entity\Facultad 
     */
    public function getFacultad()
    {
        return $this->facultad;
    }

    /**
     * Set carrera
     *
     * @param \Sistema\FacultadBundle\Entity\Carrera $carrera
     * @return Informacionperfilprofesor
     */
    public function setCarrera(\Sistema\FacultadBundle\Entity\Carrera $carrera = null)
    {
        $this->carrera = $carrera;
    
        return $this;
    }

    /**
     * Get carrera
     *
     * @return \Sistema\FacultadBundle\Entity\Carrera 
     */
    public function getCarrera()
    {
        return $this->carrera;
    }

    /**
     * Set materia
     *
     * @param \Sistema\FacultadBundle\Entity\Materia $materia
     * @return Informacionperfilprofesor
     */
    public function setMateria(\Sistema\FacultadBundle\Entity\Materia $materia = null)
    {
        $this->materia = $materia;
    
        return $this;
    }

    /**
     * Get materia
     *
     * @return \Sistema\FacultadBundle\Entity\Materia 
     */
    public function getMateria()
    {
        return $this->materia;
    }

    /**
     * Set usuarioprof
     *
     * @param \Sistema\UsuariosBundle\Entity\Profesor $usuarioprof
     * @return Informacionperfilprofesor
     */
    public function setUsuarioprof(\Sistema\UsuariosBundle\Entity\Profesor $usuarioprof = null)
    {
        $this->usuarioprof = $usuarioprof;
    
        return $this;
    }

    /**
     * Get usuarioprof
     *
     * @return \Sistema\UsuariosBundle\Entity\Profesor 
     */
    public function getUsuarioprof()
    {
        return $this->usuarioprof;
    }
}