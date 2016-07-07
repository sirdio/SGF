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
 * @ORM\Entity(repositoryClass="Sistema\FacultadBundle\Entity\MateriaRepository")
 * @ORM\Table(name="Materia")
 */
class Materia {
     /**
     * @var integer
     *
     * @ORM\Column(name="Mat_Codigo", type="integer")
     *@ORM\id
     *
     */
    private $Mat_Codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="Mat_Nombre", type="string", length=255)
     * 
     */
    private $Mat_Nombre;

    /**
     * Set Mat_Codigo
     *
     * @param integer $matCodigo
     * @return Materia
     */
    public function setMatCodigo($matCodigo)
    {
        $this->Mat_Codigo = $matCodigo;
    
        return $this;
    }

    /**
     * Get Mat_Codigo
     *
     * @return integer 
     */
    public function getMatCodigo()
    {
        return $this->Mat_Codigo;
    }

    /**
     * Set Mat_Nombre
     *
     * @param string $matNombre
     * @return Materia
     */
    public function setMatNombre($matNombre)
    {
        $this->Mat_Nombre = $matNombre;
    
        return $this;
    }

    /**
     * Get Mat_Nombre
     *
     * @return string 
     */
    public function getMatNombre()
    {
        return $this->Mat_Nombre;
    }
    
    public function __toString() 
    {
        return $this->getMatNombre();//getMateria();
    }
}