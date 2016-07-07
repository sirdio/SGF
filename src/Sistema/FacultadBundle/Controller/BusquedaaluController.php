<?php

namespace Sistema\FacultadBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;

use Sistema\FacultadBundle\form\MostrarFType;
//use Sistemagf\FacultadBundle\form\MostrarCType;
class BusquedaaluController extends Controller
{
    public function indexAction(Request $request)
    {
        return $this->render('FacultadBundle:Default:index.html.twig');
    }
    
    public function BuscaraluAction()
    {
        $em = $this->getDoctrine()->getManager();
        $facultad = $em->getRepository('FacultadBundle:Facultad')->findAll();
        $carrera = $em->getRepository('FacultadBundle:Carrera')->findAll();
        $materia = $em->getRepository('FacultadBundle:Carrera')->findAll();
        if (!$facultad and !$carrera and !$materia){
            $mensaje ="No estan cargadas las facultades, carreras y materias, que es información necesaria para poder ver los apuntes.";
            return $this->render('FacultadBundle:Default:MsjBusquedaalu.html.twig', array('mensaje'=>$mensaje));    
        }else{
            $Form = $this->createForm(new MostrarFType(), $facultad);
            return $this->render('FacultadBundle:Default:busquedageneralalu.html.twig',
            array('facultad'=> $facultad,'form'=> $Form->createView(),));                                
        }

    }
    
    public function BuscarCaluAction($id)
    {
        
//        die($id);
        $repository = $this->getDoctrine()->getRepository('FacultadBundle:Carrera');
        $carrera = $repository->FindBycarrera($id);
         
        if (!$carrera) {
            $mensaje ="No estan cargadas las carreras, que es información necesaria para poder ver los apuntes.";
            return $this->render('FacultadBundle:Default:MsjBusquedaalu.html.twig', array('mensaje'=>$mensaje));    
       }
        return $this->render('FacultadBundle:Default:buscarcarrera.html.twig',
        array('carrera'=> $carrera));
    }
    public function BuscarMaluAction($id)
    {
//        $repository = $this->getDoctrine()->getRepository('FacultadBundle:Materia');
//        $materia = $repository->FindBymateria($id) ;
       
        $em = $this->getDoctrine()->getManager();
        $materia = $em->getRepository('FacultadBundle:Carrera')->find($id);
        
        $materia = $materia->getCarreraMaterias();
        
        
       if (!$materia) {
            $mensaje ="No estan cargadas las materias, que es información necesaria para poder ver los apuntes.";
            return $this->render('FacultadBundle:Default:MsjBusquedaalu.html.twig', array('mensaje'=>$mensaje)); 
       }
       
        
        return $this->render('FacultadBundle:Default:buscarmateria.html.twig',
        array('materia'=> $materia, 'id'=> $id));
    }    
    
      
    
    
}