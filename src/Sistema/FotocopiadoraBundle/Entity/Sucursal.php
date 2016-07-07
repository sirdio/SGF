<?php

namespace Sistema\FotocopiadoraBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraint as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Sucursal
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Sistema\FotocopiadoraBundle\Entity\SucursalRepository")
 */
class Sucursal
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
    * @var string
    *
    * @ORM\Column(name="sucnomb", type="string", length=60)
    */        
    private $SucNomb;
    /**
    * @var string
    *
    * @ORM\Column(name="sucdom", type="string", length=80)
    */            
    private $SucDom;
    /**
    * @var string
    *
    * @ORM\Column(name="suctel", type="string", length=80)
    */
    private $SucTel;
    /**
    * @var string
    *
    * @ORM\Column(name="sucemail", type="string", length=80)
    */    
    private $SucEmail;
//    /**
//    * @ORM\OneToMany(targetEntity="Sistema\UsuariosBundle\Entity\Empleado", 
//     * mappedBy="Sistema\FotocopiadoraBundle\Entity\Sucursal")
//    */
//    protected $empleado;
    public function __construct()
    {
//        $this->Empleados = new ArrayCollection();
    }    
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
     * Set SucNomb
     *
     * @param string $sucNomb
     * @return Sucursal
     */
    public function setSucNomb($sucNomb)
    {
        $this->SucNomb = $sucNomb;
    
        return $this;
    }

    /**
     * Get SucNomb
     *
     * @return string 
     */
    public function getSucNomb()
    {
        return $this->SucNomb;
    }

    /**
     * Set SucDom
     *
     * @param string $sucDom
     * @return Sucursal
     */
    public function setSucDom($sucDom)
    {
        $this->SucDom = $sucDom;
    
        return $this;
    }

    /**
     * Get SucDom
     *
     * @return string 
     */
    public function getSucDom()
    {
        return $this->SucDom;
    }

    /**
     * Set SucTel
     *
     * @param string $sucTel
     * @return Sucursal
     */
    public function setSucTel($sucTel)
    {
        $this->SucTel = $sucTel;
    
        return $this;
    }

    /**
     * Get SucTel
     *
     * @return string 
     */
    public function getSucTel()
    {
        return $this->SucTel;
    }

    /**
     * Set SucEmail
     *
     * @param string $sucEmail
     * @return Sucursal
     */
    public function setSucEmail($sucEmail)
    {
        $this->SucEmail = $sucEmail;
    
        return $this;
    }

    /**
     * Get SucEmail
     *
     * @return string 
     */
    public function getSucEmail()
    {
        return $this->SucEmail;
    }


    public function __toString()
    {
        return $this->getSucNomb();
    }

//    /**
//     * Add empleado
//     *
//     * @param \Sistema\UsuariosBundle\Entity\Empleado $empleado
//     * @return Sucursal
//     */
//    public function addEmpleado(\Sistema\UsuariosBundle\Entity\Empleado $empleado)
//    {
//        $this->empleado[] = $empleado;
//    
//        return $this;
//    }
//
//    /**
//     * Remove empleado
//     *
//     * @param \Sistema\UsuariosBundle\Entity\Empleado $empleado
//     */
//    public function removeEmpleado(\Sistema\UsuariosBundle\Entity\Empleado $empleado)
//    {
//        $this->empleado->removeElement($empleado);
//    }
//
//    /**
//     * Get empleado
//     *
//     * @return \Doctrine\Common\Collections\Collection 
//     */
//    public function getEmpleado()
//    {
//        return $this->empleado;
//    }
}