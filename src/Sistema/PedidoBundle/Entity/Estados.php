<?php

namespace Sistema\PedidoBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Estados
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Sistema\PedidoBundle\Entity\EstadosRepository")
 */
class Estados
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
     * @ORM\Column(name="estadonom", type="string", length=255)
     */
    private $estadonom;

   

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
     * Set estadonom
     *
     * @param string $estadonom
     * @return Estados
     */
    public function setEstadonom($estadonom)
    {
        $this->estadonom = $estadonom;
    
        return $this;
    }

    /**
     * Get estadonom
     *
     * @return string 
     */
    public function getEstadonom()
    {
        return $this->estadonom;
    }
    
    public function __toString()
    {
        return $this->getEstadonom();
    }

}