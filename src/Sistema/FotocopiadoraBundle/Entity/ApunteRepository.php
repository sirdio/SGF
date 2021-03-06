<?php

namespace Sistema\FotocopiadoraBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ApunteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ApunteRepository extends EntityRepository
{
        public function TodolosApuntes($fid)
    {
//$Parameters = array(
//    'facultad_id' => $fid,
//    'carrera_id' => $cid,
//    'materia_id' => $maid,
//);
        $query = $this->getEntityManager()->createQuery(
        'SELECT a FROM FotocopiadoraBundle:Apunte a
          WHERE a.facultad_id =:facultad_id'
        )->setParameter('facultad_id', $fid);
 //  ->setParameters($Parameters);
//->setParameter('facultad_id', $fid)
//->setParameter('carrera_id', $cid)
//->setParameter('materia_id', $maid);
        $apuntes = $query->getResult();
        return $apuntes; 
    }
}
//$query = $em->createQuery('SELECT u.name FROM CmsUser u WHERE u.id BETWEEN ?1 AND ?2');
//$query->setParameter(1, 123);
//$query->setParameter(2, 321);
//$usernames = $query->getResult();
//       return $this->getEntityManager()
//            ->createQuery('SELECT u FROM UsuariosBundle:Usuario u where u.isActive = 0')
//            ->getResult();