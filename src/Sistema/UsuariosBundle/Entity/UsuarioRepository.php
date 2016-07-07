<?php

namespace Sistema\UsuariosBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\EntityRepository;


class UsuarioRepository extends EntityRepository implements UserProviderInterface
{

      public function loadUserByUsername( $username)
   {
    $q = $this->createQueryBuilder('u')
->select('u, g')->leftJoin('u.tipou', 'g')->where('u.username = :username OR u.email = :email')
->setParameter('username', $username)
->setParameter('email', $username)
->getQuery();

    try 
    {
         $user = $q->getSingleResult();
    } catch (NoResultException $e) {
        throw new UsernameNotFoundException(sprintf('Incapaz de encontrar un administrador activo
            SistemaUsuariosBundle:Usuario', $username), 0, $e);
    
    } 
        return $user;
    }
    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(sprintf('Los casos de "%s" no son compatibles.', $class));
        }
        return $this->loadUserByUsername($user->getUsername());
    }
    public function supportsClass($class)
    {
        return $this->getEntityName() === $class || is_subclass_of($class, $this->getEntityName());
    }
    
    public function usuarioinactivo()
    {
        return $this->getEntityManager()
            ->createQuery('SELECT u FROM UsuariosBundle:Usuario u where u.isActive = 0')
            ->getResult();
    }
    public function usuarioactivo()
    {        
         $query = $this->getEntityManager()->createQuery(
        'SELECT u.id, u.username, u.email, tu.name FROM UsuariosBundle:Usuario u, 
        UsuariosBundle:TipoUsuario tu WHERE u.isActive = 1 and  u.tipou = tu.id '
        );

        $usuarioactivo = $query->getResult();
        return $usuarioactivo;   
        
        
    }
    
    public function usuarionoactivo()
    {        
         $query = $this->getEntityManager()->createQuery(
        'SELECT u.id, u.username, u.email, tu.name FROM UsuariosBundle:Usuario u,
        UsuariosBundle:TipoUsuario tu WHERE u.isActive = 0 and  u.tipou = tu.id '
        );

        $usuarionoactivo = $query->getResult();
        return $usuarionoactivo;       
    }
    
    public function usuarionoactivo2()
    {        
         $query = $this->getEntityManager()->createQuery(
        'SELECT u FROM UsuariosBundle:Usuario u WHERE u.isActive = 0 '
        );

        $usuarionoactivo = $query->getResult();
        return $usuarionoactivo;       
    }
    
    public function empleados()
    {        
         $query = $this->getEntityManager()->createQuery(
        'SELECT u.id, u.username, u.email, tu.name FROM UsuariosBundle:Usuario u,
        UsuariosBundle:TipoUsuario tu WHERE u.tipou = tu.id and tu.id = 3'
        );

        $empleado = $query->getResult();
        return $empleado;       
    }
    
//    public function modificardatos($id)
//    {        
//         $query = $this->getEntityManager()->createQuery(
//        'SELECT u.username FROM UsuariosBundle:empleado u WHERE u.id =:id'
//        )->setParameter('id', $id);
//
//        $entity = $query->getResult();
//        return $entity;       
//    }
    
}
