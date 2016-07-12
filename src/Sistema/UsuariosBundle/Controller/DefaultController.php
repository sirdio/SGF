<?php

namespace Sistema\UsuariosBundle\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sistema\UsuariosBundle\Entity\Usuario;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('UsuariosBundle:Default:index.html.twig', array('name' => $name));
    }

    public function loginAction()
    {
        $peticion = $this->getRequest();
        $sesion = $peticion->getSession();
        $error = $peticion->attributes->get(
        SecurityContext::AUTHENTICATION_ERROR, $sesion->get(SecurityContext::AUTHENTICATION_ERROR));
        
        return $this->render('UsuariosBundle:Default:login.html.twig', array(
        'last_username' => $sesion->get(SecurityContext::LAST_USERNAME), 'error' => $error));
    }   

    public function IrAlumAction(Request $request)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        return $this->render('UsuariosBundle:Default:pagAlu.html.twig', 
                array('user' => $user));
    }
   
    public function IrProfAction(Request $request)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        return $this->render('UsuariosBundle:Default:pagProf.html.twig', array('user' => $user));
    }
    public function IrEmpAction(Request $request)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        return $this->render('UsuariosBundle:Default:pagEmp.html.twig', array('user' => $user));
    }
    public function IrAdmAction(Request $request)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        return $this->render('UsuariosBundle:Default:pagAdmin.html.twig', array('user' => $user));
    }
}
