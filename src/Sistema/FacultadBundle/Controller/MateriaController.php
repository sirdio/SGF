<?php

/**
 * Descripción de MateriaController
 *
 * @author Siedio
 */
namespace Sistema\FacultadBundle\Controller;
use Sistema\FacultadBundle\Entity\Materia;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sistema\FacultadBundle\form\MateriaType;

class MateriaController extends Controller
{
    public function InicioMAction(Request $request)
    {
        $total_count=$this->getTotalProductos();
        $page=$request->get('page');
        $porpagina=30;        
        $totalPaginas=ceil($total_count/$porpagina);
        if(!is_numeric($page))
        {
            $page=1;
        }else{
             $page=floor($page);
        }        
        if($total_count<=$porpagina)
        {
            $page=1;
        } 
        if(($page*$porpagina)>$total_count)
        {
            $page=$totalPaginas;
        }
        $offset=0;
        if($page>1)
        {
            $offset=$porpagina*($page-1);
        }        
        $em=$this->getDoctrine()
                        ->getManager()
                        ->createQueryBuilder('FacultadBundle:Materia')
                        ->select('m')
                        ->from('FacultadBundle:Materia','m')
                        ->orderBy("m.Mat_Codigo","asc")
                        ->setFirstResult($offset)
                        ->setMaxResults($porpagina)
                        ->getQuery();
        $datos=$em->getArrayResult();
        return $this->render('FacultadBundle:Materia:InicioM.html.twig',compact("datos","porpagina","totalPaginas","total_count","page"));             
    }
    public function AgregarMAction(Request $request)
    {
        $materia = new Materia();
        $form = $this->createForm(new MateriaType(), $materia);
        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()){
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($materia);
                $em->flush();
                
                return $this->render('FacultadBundle:Materia:MsjAM.html.twig');
            }
            return $this->render('FacultadBundle:Materia:AgregarM.html.twig',
                array('materia'=> $materia, 'form' => $form ->createView(),));
    }
            return $this->render('FacultadBundle:Materia:AgregarM.html.twig',
                array('materia'=> $materia, 'form' => $form ->createView(),));
    }

    public function ListarMAction(Request $request)
    {
        $total_count=$this->getTotalProductos();
        $page=$request->get('page');
        $porpagina=30;        
        $totalPaginas=ceil($total_count/$porpagina);
        if(!is_numeric($page))
        {
            $page=1;
        }else{
             $page=floor($page);
        }        
        if($total_count<=$porpagina)
        {
            $page=1;
        } 
        if(($page*$porpagina)>$total_count)
        {
            $page=$totalPaginas;
        }
        $offset=0;
        if($page>1)
        {
            $offset=$porpagina*($page-1);
        }        
        $em=$this->getDoctrine()
                        ->getManager()
                        ->createQueryBuilder('FacultadBundle:Materia')
                        ->select('m')
                        ->from('FacultadBundle:Materia','m')
                        ->orderBy("m.Mat_Codigo","asc")
                        ->setFirstResult($offset)
                        ->setMaxResults($porpagina)
                        ->getQuery();
        $datos=$em->getArrayResult();
       if (!$datos) {
            return $this->render('FacultadBundle:Materia:MsjConsulM1.html.twig');
       }       
       return $this->render('FacultadBundle:Materia:ListarM.html.twig',compact("datos","porpagina","totalPaginas","total_count","page"));        
    }

    public function EditarMAction($Mat_Codigo)
    {
        $em = $this->getDoctrine()->getManager();
        $materia = $em->getRepository('FacultadBundle:Materia')->find($Mat_Codigo);
        $editForm = $this->createForm(new MateriaType(), $materia);
        return $this->render('FacultadBundle:Materia:editarM.html.twig',
                array('materia'=> $materia,'edit_form'=> $editForm->createView(),));
    }
    
    public function GuardarMAction(Request $request, $Mat_Codigo)
    {
        $em = $this->getDoctrine()->getManager();
        $materia = $em->getRepository('FacultadBundle:Materia')->find($Mat_Codigo);
        $editForm = $this->createForm(new MateriaType(), $materia);
        $editForm->bind($request);
        if ($editForm->isValid()) {
            $em->persist($materia);
            $em->flush();
            return $this->render('FacultadBundle:Materia:MsjAM.html.twig');
        }
        return $this->render('FacultadBundle:Materia:editarM.html.twig',
                array('materia' => $materia,'edit_form' => $editForm->createView(),));   
    }
    
    public function getTotalProductos()
    {        
        $datos=$this->getDoctrine()
                            ->getManager()
                            ->createQueryBuilder('FacultadBundle:Materia')
                            ->select('Count(m)')
                            ->from('FacultadBundle:Materia','m')
                            ->getQuery()
                            ->getSingleScalarResult();
        return $datos;
    }
}

?>
