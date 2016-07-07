<?php

namespace Sistema\FacultadBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;

use Sistema\FacultadBundle\form\MostrarFType;
//use Sistemagf\FacultadBundle\form\MostrarCType;
class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        return $this->render('FacultadBundle:Default:index.html.twig');
    }
    
    public function BuscarAction()
    {
        $em = $this->getDoctrine()->getManager();
        $facultad = $em->getRepository('FacultadBundle:Facultad')->findAll();
        $carrera = $em->getRepository('FacultadBundle:Carrera')->findAll();
        $materia = $em->getRepository('FacultadBundle:Carrera')->findAll();
        if (!$facultad and !$carrera and !$materia){
            return $this->render('FacultadBundle:Default:MsjBusqueda.html.twig');    
        }else{
            $Form = $this->createForm(new MostrarFType(), $facultad);
            return $this->render('FacultadBundle:Default:busquedageneral.html.twig',
            array('facultad'=> $facultad,'form'=> $Form->createView(),));                                
        }

    }
    
    public function BuscarCAction($id)
    {
        
//        die($id);
        $repository = $this->getDoctrine()->getRepository('FacultadBundle:Carrera');
        $carrera = $repository->FindBycarrera($id);
         
        if (!$carrera) {
            return $this->render('facultadBundle:Default:index.html.twig');
       }
        return $this->render('FacultadBundle:Default:buscarcarrera.html.twig',
        array('carrera'=> $carrera));
    }
    public function BuscarMAction($id)
    {
//        $repository = $this->getDoctrine()->getRepository('FacultadBundle:Materia');
//        $materia = $repository->FindBymateria($id) ;
       
        $em = $this->getDoctrine()->getManager();
        $materia = $em->getRepository('FacultadBundle:Carrera')->find($id);
        
        $materia = $materia->getCarreraMaterias();
        
        
       if (!$materia) {
            return $this->render('facultadBundle:Default:index.html.twig');
       }
       
        
        return $this->render('FacultadBundle:Default:buscarmateria.html.twig',
        array('materia'=> $materia, 'id'=> $id));
    }    
    
      
    
    
}
