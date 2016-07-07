<?php

namespace Sistema\MsjinternaBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Mapping as ORM;

/**
 * 
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Sistema\MsjinternaBundle\Entity\MensajeRepository")
 */
class Mensaje {
     /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
    * @ORM\Column(name="nombreremitente", type="string", length=250)
    * 
    */ 
    private $nombreremitente; 
    
    /**
    * @ORM\ManyToOne(targetEntity="\Sistema\UsuariosBundle\Entity\Informacionperfilprofesor")
    * @ORM\JoinColumn(name="datomateriaid", referencedColumnName="id")
    */
    private $datomateria;

    /**
    * @ORM\Column(name="asunto", type="string", length=250)
    * 
    */    
    protected $asunto;        
    
    /**
    * @ORM\Column(name="descripcion", type="string", length=500)
    * 
    */    
    protected $descripcion;    
    
    /**
    * @ORM\Column(name="fechaenvio", type="string", length=10)
    * 
    */    
    protected $fechaenvio;
    
    /**
    * @ORM\Column(name="is_active", type="boolean")
    */
    private $isActive;    
    
    /**
    * @ORM\Column(type="string", length=255, nullable=true)
    */
    public $path;    
    
    private $temp;
    
      /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;    

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
     * Set descripcion
     *
     * @param string $descripcion
     * @return Mensaje
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
     * Set fechaenvio
     *
     * @param string $fechaenvio
     * @return Mensaje
     */
    public function setFechaenvio($fechaenvio)
    {
        $this->fechaenvio = $fechaenvio;
    
        return $this;
    }

    /**
     * Get fechaenvio
     *
     * @return string 
     */
    public function getFechaenvio()
    {
        return $this->fechaenvio;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Mensaje
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
     * Set path
     *
     * @param string $path
     * @return Mensaje
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
   
    /**
     * Set datomateria
     *
     * @param \Sistema\UsuariosBundle\Entity\Informacionperfilprofesor $datomateria
     * @return Mensaje
     */
    public function setDatomateria(\Sistema\UsuariosBundle\Entity\Informacionperfilprofesor $datomateria = null)
    {
        $this->datomateria = $datomateria;
    
        return $this;
    }

    /**
     * Get datomateria
     *
     * @return \Sistema\UsuariosBundle\Entity\Informacionperfilprofesor 
     */
    public function getDatomateria()
    {
        return $this->datomateria;
    }

    /**
     * Set asunto
     *
     * @param string $asunto
     * @return Mensaje
     */
    public function setAsunto($asunto)
    {
        $this->asunto = $asunto;
    
        return $this;
    }

    /**
     * Get asunto
     *
     * @return string 
     */
    public function getAsunto()
    {
        return $this->asunto;
    }
    
//    public function __toString()
//    {
//        return $this->getAsun();
//        
//    }    

    /**
     * Set nombreremitente
     *
     * @param string $nombreremitente
     * @return Mensaje
     */
    public function setNombreremitente($nombreremitente)
    {
        $this->nombreremitente = $nombreremitente;
    
        return $this;
    }

    /**
     * Get nombreremitente
     *
     * @return string 
     */
    public function getNombreremitente()
    {
        return $this->nombreremitente;
    }
}