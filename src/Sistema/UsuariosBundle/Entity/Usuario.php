<?php

namespace Sistema\UsuariosBundle\Entity;
use Symfony\Component\Validator\Constraint as Assert;
use Doctrine\ORM\Mapping as ORM;
//use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraint\NotBlank;
use Symfony\Component\Validator\Constraint\NotBlankValidator;
use Symfony\Component\Validator\Constraint\NotNull;



/**
*
* @ORM\Entity
* @ORM\Table(name="usuario")
* @ORM\Entity(repositoryClass="Sistema\UsuariosBundle\Entity\UsuarioRepository") 
* @ORM\DiscriminatorMap({"alumno" = "Alumno", "profesor" = "Profesor", "empleado" = "Empleado"})
* @ORM\InheritanceType("JOINED")
* @ORM\DiscriminatorColumn(name="tipo", type="string")
*/

///**
// *
// * @ORM\Entity
// * @ORM\Table(name="usuario")
// * @ORM\Entity(repositoryClass="Sistema\UsuariosBundle\Entity\UsuarioRepository")
// */
class Usuario implements AdvancedUserInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=150, unique=true)
     * 
     */    
    private $email;
    /**
    * @ORM\Column(type="string", length=25, unique=true)
    */
    private $username;  
    /**
    * @ORM\Column(type="string", length=250)
    */    
    private $nombre;
    /**
    * @ORM\Column(type="string", length=150)
    */    
    private $apellido;
    /**
    * @ORM\Column(type="string", length=20)
    */    
    private $nrocel;
    /**
    * @ORM\Column(type="string", length=100)
    */
    private $salt;    
    /**
    * @ORM\Column(type="string", length=250)
    */
    private $password;        
    /**
    * @ORM\Column(name="is_active", type="boolean")
    */
    private $isActive;

    /**
    * @ORM\ManyToOne(targetEntity="TipoUsuario")
    * @ORM\JoinColumn(name="tpu_id", referencedColumnName="id")
    *
    */
    protected $tipou;

    ////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////
    public function __construct()
    {
        $this->isActive = false;
        $this->salt = md5(uniqid(null, true));
    }    
    ////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////
    public function eraseCredentials() {
//        return true;
    }

    public function getPassword() 
    {
        return $this->password;
    }

    public function getRoles() 
    {
        if ($this->getTipou()== 'Profesor') {
            return array('ROLE_PROF');
        }elseif($this->getTipou()== 'Alumno'){
            return array('ROLE_ALUMNO');
        }elseif($this->getTipou()== 'Empleado'){
            return array('ROLE_EMP');            
        }elseif($this->getTipou()== 'Administrador'){
            return array('ROLE_ADMIN');
        }
      
    }

    public function getSalt() 
    {
        return $this->salt;
    }

    public function getUsername() 
    {
        return $this->username;
    }

    public function isAccountNonExpired() 
    {
        return true;
    }

    public function isAccountNonLocked() 
    {
        return true;
    }

    public function isCredentialsNonExpired() 
    {
        return true;
    }

    ////////////////////////////////////////////////////////////////////////////
    public function isEnabled()
    {
        return $this->isActive;
    }
    
    public function serialize()
    {
        return serialize(array(
            $this->id,
        ));
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
        ) = unserialize($serialized);
    }
  
    ////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////
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
     * Set email
     *
     * @param string $email
     * @return Usuario
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return Usuario
     */
    public function setUsername($username)
    {
        $this->username = $username;
    
        return $this;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return Usuario
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    
        return $this;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Usuario
     */
    public function setPassword($password)
    {
        $this->password = $password;
    
        return $this;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Usuario
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
     * Set tipou
     *
     * @param \Sistema\UsuariosBundle\Entity\TipoUsuario $tipou
     * @return Usuario
     */
    public function setTipou(\Sistema\UsuariosBundle\Entity\TipoUsuario $tipou = null)
    {
        $this->tipou = $tipou;
    
        return $this;
    }

    /**
     * Get tipou
     *
     * @return \Sistema\UsuariosBundle\Entity\TipoUsuario 
     */
    public function getTipou()
    {
        return $this->tipou;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Usuario
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
     * Set apellido
     *
     * @param string $apellido
     * @return Usuario
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    
        return $this;
    }

    /**
     * Get apellido
     *
     * @return string 
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set nrocel
     *
     * @param string $nrocel
     * @return Usuario
     */
    public function setNrocel($nrocel)
    {
        $this->nrocel = $nrocel;
    
        return $this;
    }

    /**
     * Get nrocel
     *
     * @return string 
     */
    public function getNrocel()
    {
        return $this->nrocel;
    }
}