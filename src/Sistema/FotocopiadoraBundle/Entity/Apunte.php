<?php

namespace Sistema\FotocopiadoraBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
/**
 * Apunte
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Sistema\FotocopiadoraBundle\Entity\ApunteRepository")
 */
/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Apunte {
    /**
    * @ORM\Column(name="id", type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    private $id;

    /**
    * @ORM\Column(name="nombre",type="string", length=255)
    * @Assert\NotBlank
    */
    private $nombre;
    
    /**
    * @ORM\Column(name="fecha", type="string", length=10)
    * @Assert\NotBlank
    */   
    private $fecha;
    
    /**
    * @ORM\Column(name="nropag", type="integer")
    * @Assert\NotBlank
    */    
    private $nropag;
    
    /**
    * @ORM\Column(name="precio",type="decimal", scale=2)
    * @Assert\NotBlank
    */
    private $precio;
    
    /**
    * @ORM\Column(name="observacion", type="string", length=500)
    * @Assert\NotBlank 
    */    
    private $observacion;
    
    /**
    * @ORM\Column(name="facultad_id", type="integer")
    * @Assert\NotBlank 
    */
    private $facultad_id;
    

    /**
    * @ORM\Column(name="carrera_id", type="integer")
    * @Assert\NotBlank 
    */
    private $carrera_id;
    
    /**
    * @ORM\Column(name="materia_id", type="integer")
    * @Assert\NotBlank 
    */
    private $materia_id;
        
    /**
    * @ORM\Column(type="string", length=255, nullable=true)
    */
    public $path;
    
    private $temp;
    
      /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;

            
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////    
//    
//    public function getFile()
//    {
//        return $this->file;
//    }
    
    
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
     * Set nombre
     *
     * @param string $nombre
     * @return Apunte
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    
        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Apunte
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    
        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set nropag
     *
     * @param integer $nropag
     * @return Apunte
     */
    public function setNropag($nropag)
    {
        $this->nropag = $nropag;
    
        return $this;
    }

    /**
     * Get nropag
     *
     * @return integer 
     */
    public function getNropag()
    {
        return $this->nropag;
    }

    /**
     * Set precio
     *
     * @param float $precio
     * @return Apunte
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;
    
        return $this;
    }

    /**
     * Get precio
     *
     * @return float 
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set observacion
     *
     * @param string $observacion
     * @return Apunte
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;
    
        return $this;
    }

    /**
     * Get observacion
     *
     * @return string 
     */
    public function getObservacion()
    {
        return $this->observacion;
    }

    /**
     * Set facultad_id
     *
     * @param integer $facultadId
     * @return Apunte
     */
    public function setFacultadId($facultadId)
    {
        $this->facultad_id = $facultadId;
    
        return $this;
    }

    /**
     * Get facultad_id
     *
     * @return integer 
     */
    public function getFacultadId()
    {
        return $this->facultad_id;
    }

    /**
     * Set carrera_id
     *
     * @param integer $carreraId
     * @return Apunte
     */
    public function setCarreraId($carreraId)
    {
        $this->carrera_id = $carreraId;
    
        return $this;
    }

    /**
     * Get carrera_id
     *
     * @return integer 
     */
    public function getCarreraId()
    {
        return $this->carrera_id;
    }

    /**
     * Set materia_id
     *
     * @param integer $materiaId
     * @return Apunte
     */
    public function setMateriaId($materiaId)
    {
        $this->materia_id = $materiaId;
    
        return $this;
    }

    /**
     * Get materia_id
     *
     * @return integer 
     */
    public function getMateriaId()
    {
        return $this->materia_id;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Apunte
     */
    public function setPath($path)
    {
        $this->path = $path;
    
        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }
//    public function total()
//    {
//        echo $apuntes->getPrecio();
//    }
        public function __toString()
    {
        return $this->getNombre();
        
    }
}