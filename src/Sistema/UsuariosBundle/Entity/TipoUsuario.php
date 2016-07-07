<?php

namespace Sistema\UsuariosBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Table(name="TipoUsuario")
 * @ORM\Entity(repositoryClass="Sistema\UsuariosBundle\Entity\TipoUsuarioRepository")
 */
class TipoUsuario
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
    * @ORM\Column(name="name", type="string", length=30)
    */
    private $name;
    
        /**
    * @ORM\Column(name="estado", type="boolean", nullable=true)
    */
    private $estado;

    /**
    * @ORM\Column(name="tipus", type="string", length=20, unique=true)
    */
    private $tipus;    

    ////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////
    public function __toString()
    {
        return $this->getName();
    }
    
    ////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////
    
    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setTipus($tipus)
    {
        $this->tipus = $tipus;
    
        return $this;
    }

    public function getTipus()
    {
        return $this->tipus;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;
    
        return $this;
    }

    public function getEstado()
    {
        return $this->estado;
    }
    public function getConsulta()
    {
        $valor = $this->getEstado();
        if(empty($valor)){
            return NULL;            
        }else{
            return $this->getName();
        }
    }
}