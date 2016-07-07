<?php
namespace Sistema\UsuariosBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;


/**
 * Pagos
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Sistema\UsuariosBundle\Entity\InformacionperfilesRepository")
 */
class Informacionperfiles 
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
    * @ORM\ManyToOne(targetEntity="Alumno")
    * @ORM\JoinColumn(name="alumnoid", referencedColumnName="id")
    */
    private $usuarioalu; 
    


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
     * Set usuarioalu
     *
     * @param \Sistema\UsuariosBundle\Entity\Alumno $usuarioalu
     * @return Informacionperfiles
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
     * Set materia
     *
     * @param \Sistema\FacultadBundle\Entity\Materia $materia
     * @return Informacionperfiles
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
     * Set facultad
     *
     * @param \Sistema\FacultadBundle\Entity\Facultad $facultad
     * @return Informacionperfiles
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
     * @return Informacionperfiles
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
}