<?php

namespace Sistema\UsuariosBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="Profesor")
 * @ORM\Entity(repositoryClass="Sistema\UsuariosBundle\Entity\AlumnoRepository")
 * 
 * 
 */

class Profesor extends Usuario 
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
    * @ORM\Column(name="fechacreacion", type="string", length=10)
    * 
    */    
    protected $fechacreacion;
    
    /**
    * @ORM\Column(name="fechaultmod", type="string", length=10)
    * 
    */    
    protected $fechaultmod;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

//    /**
//     * @var \Sistema\UsuariosBundle\Entity\TipoUsuario
//     */
//    private $tipou;


    /**
     * Set fechacreacion
     *
     * @param string $fechacreacion
     * @return Profesor
     */
    public function setFechacreacion($fechacreacion)
    {
        $this->fechacreacion = $fechacreacion;
    
        return $this;
    }

    /**
     * Get fechacreacion
     *
     * @return string 
     */
    public function getFechacreacion()
    {
        return $this->fechacreacion;
    }

    /**
     * Set fechaultmod
     *
     * @param string $fechaultmod
     * @return Profesor
     */
    public function setFechaultmod($fechaultmod)
    {
        $this->fechaultmod = $fechaultmod;
    
        return $this;
    }

    /**
     * Get fechaultmod
     *
     * @return string 
     */
    public function getFechaultmod()
    {
        return $this->fechaultmod;
    }

//    /**
//     * Set tipou
//     *
//     * @param \Sistema\UsuariosBundle\Entity\TipoUsuario $tipou
//     * @return Profesor
//     */
//    public function setTipou(\Sistema\UsuariosBundle\Entity\TipoUsuario $tipou = null)
//    {
//        $this->tipou = $tipou;
//    
//        return $this;
//    }
//
//    /**
//     * Get tipou
//     *
//     * @return \Sistema\UsuariosBundle\Entity\TipoUsuario 
//     */
//    public function getTipou()
//    {
//        return $this->tipou;
//    }
}