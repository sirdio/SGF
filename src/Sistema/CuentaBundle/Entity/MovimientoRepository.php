<?php

namespace Sistema\CuentaBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * MovimientoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MovimientoRepository extends EntityRepository
{

//    public function Leermovimientos($nrocta)
//    {        
//         $query = $this->getEntityManager()->createQueryBuilder('CuentaBundle:Movimiento')
//        ->select('m')
//        ->from('CuentaBundle:Movimiento m')
//        ->where('mr.nrocuenta = :nrocta')         
//         ->orderBy("m.id","asc")
//        ->setParameter('nrocta', $nrocta);
//        $datos = $query->getResult();
//        return $datos;       
////    
////       $q = $this->createQueryBuilder('u')
////->select('u, g')->leftJoin('u.tipou', 'g')->where('u.username = :username OR u.email = :email')
////->setParameter('username', $username)
////->setParameter('email', $username)
////->getQuery();     
//               
//         $query = $this->getEntityManager()->createQuery(
//        'SELECT m FROM CuentaBundle:Movimiento m WHERE m.nrocuenta = :nrocta'
//        )->setParameter('nrocta', $nrocta);
//
//        $datos = $query->getResult();
//        return $datos;      
//        
//        
//        
//        
//        
//        
//        
//    }
//    
//    $em = $this->getDoctrine()->getManager();
//$query = $em->createQuery(
//    'SELECT a
//    FROM MyRecipesBundle:Author a
//    JOIN a.recipes r
//    WHERE r.difficulty = :difficulty
//    ORDER BY a.surname DESC'
//)->setParameter('difficulty', 'difícil');
//
//$hardcore_authors = $query->getResult();
    
    
}