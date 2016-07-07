<?php

namespace Sistema\UsuariosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sistema\UsuariosBundle\Entity\TipoUsuario;
use Sistema\UsuariosBundle\Form\TipoUsuarioType;

/**
 * Description of TipoUsuarioController
 *
 * @author SirdioEsc
 */
class TipoUsuarioController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('UsuariosBundle:TipoUsuario')->findAll();

        return $this->render('UsuariosBundle:TipoUsuario:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    public function createAction(Request $request)
    {
        $entity  = new TipoUsuario();
        $form = $this->createForm(new TipoUsuarioType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('rol'));
        }

        return $this->render('UsuariosBundle:TipoUsuario:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    public function newAction()
    {
        $entity = new TipoUsuario();
        $form   = $this->createForm(new TipoUsuarioType(), $entity);

        return $this->render('UsuariosBundle:TipoUsuario:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
 
    public function ListarAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('UsuariosBundle:TipoUsuario')->findAll();
        if (!$entities) {
            $mensaje = "No existen datos para modificar.";
            return $this->render('UsuariosBundle:TipoUsuario:mensjetu.html.twig', array(
        'mensaje' => $mensaje,));
        }
        return $this->render('UsuariosBundle:TipoUsuario:ListarTU.html.twig', array(
        'entities' => $entities,));
    }
    
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UsuariosBundle:TipoUsuario')->find($id);

        if (!$entity) {
            $mensaje = "No existen datos para modificar.";
            return $this->render('UsuariosBundle:TipoUsuario:mensjetu.html.twig', array(
        'mensaje' => $mensaje,));
        }

        $editForm = $this->createForm(new TipoUsuarioType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('UsuariosBundle:TipoUsuario:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UsuariosBundle:TipoUsuario')->find($id);

        if (!$entity) {
            $mensaje = "No existen datos para modificar.";
            return $this->render('UsuariosBundle:TipoUsuario:mensjetu.html.twig', array(
        'mensaje' => $mensaje,));
        }
        $editForm = $this->createForm(new TipoUsuarioType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('rol'));
        }

        return $this->render('UsuariosBundle:TipoUsuario:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }


}


?>
