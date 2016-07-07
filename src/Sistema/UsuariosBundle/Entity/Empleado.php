<?php

namespace Sistema\UsuariosBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="Empleado")
 * @ORM\Entity(repositoryClass="Sistema\UsuariosBundle\Entity\EmpleadoRepository")
 * 
 * 
 */

class Empleado  extends Usuario 
{
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
//    /**
//    * @ORM\ManyToOne(targetEntity="Sistema\FotocopiadoraBundle\Entity\Sucursal",
//    * inversedBy="Sistema\UsuariosBundle\Entity\Empleado")
//    * @ORM\JoinColumn(name="Sucid", referencedColumnName="id")
//    */
//    /**
//     * @ORM\OneToOne(targetEntity="Sistema\FotocopiadoraBundle\Entity\Sucursal")
//     * @ORM\JoinColumn(name="Sucid", referencedColumnName="id")
//     */    
    
//    /**
//     * @ORM\ManyToOne(targetEntity="Sistema\FotocopiadoraBundle\Entity\Sucursal")
//     * @ORM\JoinColumn(name="Sucid", referencedColumnName="id")
//     */
     
//    private $sucursal;

     /**
     *
     * @ORM\Column(name="sucid", type="string")
     */ 
    private $sucid;
    
   /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

   public function setSucid($sucid)
    {
        $this->sucid = $sucid;
    
        return $this;
    }

    public function getSucid()
    {
        return $this->sucid;
    }

  
}