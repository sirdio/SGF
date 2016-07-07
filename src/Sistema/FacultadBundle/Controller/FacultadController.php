<?php

namespace Sistema\FacultadBundle\Controller;
use Sistema\FacultadBundle\Entity\Facultad;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sistema\FacultadBundle\form\FacultadType;

class FacultadController extends Controller
{
    public function InicioFAction() 
    {
        $facultad = $this->getDoctrine()->getRepository('FacultadBundle:Facultad')->findAll();
        if (!$facultad) {
            return $this->render('FacultadBundle:Facultad:MsjConsulF1.html.twig');
        }
        return $this->render('FacultadBundle:Facultad:InicioF.html.twig', array('facultad' => $facultad));        
    }
    
    public function AgregarFAction(Request $request)
    {
        $facultad = new Facultad();
        $form = $this->createForm(new FacultadType(), $facultad);
        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()){
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($facultad);
                $em->flush();
                return $this->render('FacultadBundle:Facultad:MsjAF.html.twig');
            }
            return $this->render('FacultadBundle:Facultad:AgregarF.html.twig',
                array('facultad'=> $facultad, 'form' => $form ->createView(),));
        }
            return $this->render('FacultadBundle:Facultad:AgregarF.html.twig',
                array('facultad'=> $facultad, 'form' => $form ->createView(),));
    }
  
    public function ListarFAction()
    {
       $em = $this->getDoctrine()->getManager(); 
       $facultad= $em->getRepository('FacultadBundle:Facultad')->findAll();
       if (!$facultad) {
            return $this->render('FacultadBundle:Facultad:MsjConsulF1.html.twig');
       }
       return $this->render('FacultadBundle:Facultad:ListarF.html.twig',array('facultad'=> $facultad));   
    }

    public function EditarFAction($Fac_Codigo) 
    {
        $em = $this->getDoctrine()->getManager();
        $facultad = $em->getRepository('FacultadBundle:Facultad')->find($Fac_Codigo);
        $editForm = $this->createForm(new FacultadType(), $facultad);
        return $this->render('FacultadBundle:Facultad:editarF.html.twig',
                array('facultad'=> $facultad,'edit_form'=> $editForm->createView(),));
    }
    
    public function GuardarFAction(Request $request, $Fac_Codigo)
    {
        $em = $this->getDoctrine()->getManager();
        $facultad = $em->getRepository('FacultadBundle:Facultad')->find($Fac_Codigo);
        $editForm = $this->createForm(new FacultadType(), $facultad);
        $editForm->bind($request);
        if ($editForm->isValid()) {
            $em->persist($facultad);
            $em->flush();
            $facultad= $em->getRepository('FacultadBundle:Facultad')->findAll();
            return $this->render('FacultadBundle:Facultad:listarF.html.twig',array('facultad'=> $facultad));
        }
        return $this->render('FacultadBundle:Facultad:editarF.html.twig',
                array('facultad' => $facultad,'edit_form' => $editForm->createView(),));   
    }
}

?>
