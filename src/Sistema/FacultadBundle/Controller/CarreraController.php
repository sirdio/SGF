<?php

namespace Sistema\FacultadBundle\Controller;
use Sistema\FacultadBundle\Entity\Carrera;
use Sistema\FacultadBundle\Entity\Materia;
use Sistema\FacultadBundle\Entity\Facultad;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sistema\FacultadBundle\form\CarreraType;

class CarreraController extends Controller
{
    public function InicioCAction()
    {
        $carrera = $this->getDoctrine()->getRepository('FacultadBundle:Carrera')->findAll();
        if (!$carrera) {
            return $this->render('FacultadBundle:Carrera:MsjConsulC.html.twig');
        }
        return $this->render('FacultadBundle:Carrera:InicioC.html.twig', array('carrera' => $carrera));        
    }

    public function AgregarCAction(Request $request)
    {
        $materia = $this->getDoctrine()->getRepository('FacultadBundle:Materia')->findAll();
        $facultad = $this->getDoctrine()->getRepository('FacultadBundle:Facultad')->findAll();
        if (!$materia) {
            return $this->render('FacultadBundle:Carrera:MsjConsulM.html.twig');
        }
        if (!$facultad) {
            return $this->render('FacultadBundle:Carrera:MsjConsulF.html.twig');
        }        
        $carrera = new Carrera();
        $form = $this->createForm(new CarreraType(), $carrera);
        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()){
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($carrera);
                $em->flush();
                return $this->render('FacultadBundle:Carrera:MsjAC.html.twig');
            }
            return $this->render('FacultadBundle:Carrera:AgregarC.html.twig',
                array('carrera'=> $carrera, 'form' => $form ->createView(),));
        }
            return $this->render('FacultadBundle:Carrera:AgregarC.html.twig',
                array('carrera'=> $carrera, 'form' => $form ->createView(),));
            
    }
    
    public function ListarCAction()
    {
       $em = $this->getDoctrine()->getManager(); 
       $carrera= $em->getRepository('FacultadBundle:Carrera')->findAll();
       if (!$carrera) {
            return $this->render('FacultadBundle:Carrera:MsjConsulC.html.twig');
       }
       return $this->render('FacultadBundle:Carrera:ListarC.html.twig',array('carrera'=> $carrera));   
    }

    public function EditarCAction($Carr_Codigo)
    {
        $em = $this->getDoctrine()->getManager();
        $carrera = $em->getRepository('FacultadBundle:Carrera')->find($Carr_Codigo);
        $editForm = $this->createForm(new CarreraType(), $carrera);
        return $this->render('FacultadBundle:Carrera:editarC.html.twig',
                array('carrera'=> $carrera,'edit_form'=> $editForm->createView(),));
    }

    public function GuardarCAction(Request $request, $Carr_Codigo)
    {
        $em = $this->getDoctrine()->getManager();
        $carrera = $em->getRepository('FacultadBundle:Carrera')->find($Carr_Codigo);
        $editForm = $this->createForm(new CarreraType(), $carrera);
        $editForm->bind($request);
        if ($editForm->isValid()) {
            $em->persist($carrera);
            $em->flush();
            $carrera= $em->getRepository('FacultadBundle:Carrera')->findAll();
            return $this->render('FacultadBundle:Carrera:listarC.html.twig',array('carrera'=> $carrera));
        }
        return $this->render('FacultadBundle:Carrera:editarC.html.twig',
                array('carrera' => $carrera,'edit_form' => $editForm->createView(),));   
    }   
}

?>
