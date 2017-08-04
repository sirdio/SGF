<?php

namespace Sistema\FotocopiadoraBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sistema\FotocopiadoraBundle\Entity\Sucursal;
use Sistema\FotocopiadoraBundle\Form\SucursalType;


class SucursalController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FotocopiadoraBundle:Sucursal')->findAll();

        return $this->render('FotocopiadoraBundle:Sucursal:index.html.twig', array(
            'entities' => $entities,
        ));
    }


    public function createAction(Request $request)
    {
        $entity  = new Sucursal();
        $form = $this->createForm(new SucursalType(), $entity);
        $form->bind($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('sucursal_show', array('id' => $entity->getId())));
        }

        return $this->render('FotocopiadoraBundle:Sucursal:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }


    public function newAction()
    {
        $entity = new Sucursal();
        $form   = $this->createForm(new SucursalType(), $entity);

        return $this->render('FotocopiadoraBundle:Sucursal:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }


    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FotocopiadoraBundle:Sucursal')->find($id);
        if (!$entity) {
            return $this->render('FotocopiadoraBundle:Sucursal:MsjConsulS.html.twig');
        }
        return $this->render('FotocopiadoraBundle:Sucursal:show.html.twig', array(
            'entity'=> $entity,));
    }

  
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FotocopiadoraBundle:Sucursal')->find($id);

        if (!$entity) {
            return $this->render('FotocopiadoraBundle:Sucursal:MsjConsulS.html.twig');
        }
        $editForm = $this->createForm(new SucursalType(), $entity);
        return $this->render('FotocopiadoraBundle:Sucursal:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }

   
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FotocopiadoraBundle:Sucursal')->find($id);

        if (!$entity) {
            return $this->render('FotocopiadoraBundle:Sucursal:MsjConsulS.html.twig');
        }
        $editForm = $this->createForm(new SucursalType(), $entity);
        $editForm->bind($request);
        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('sucursal_lista'));
        }
        return $this->render('FotocopiadoraBundle:Sucursal:edit.html.twig', array(
            'entity'      => $entity, 'edit_form'   => $editForm->createView(),));
    }

    public function ListarAction()
    {
        $em = $this->getDoctrine()->getManager(); 
        $sucursal= $em->getRepository('FotocopiadoraBundle:Sucursal')->findAll();
        if (!$sucursal) {
            return $this->render('FotocopiadoraBundle:Sucursal:MsjConsulS.html.twig');
        }  
        return $this->render('FotocopiadoraBundle:Sucursal:modificars.html.twig',
                Array('sucursal'=>$sucursal));   
    }
    public function ConsultarNSAction($nomsuc){
        $em = $this->getDoctrine()->getManager();
        $sucursal= $em->getRepository('FotocopiadoraBundle:Sucursal')->findBySucNom($nomsuc);
        
        print_r($sucursal);
        die();
    }
}
