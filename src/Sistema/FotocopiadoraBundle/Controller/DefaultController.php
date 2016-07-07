<?php

namespace Sistema\FotocopiadoraBundle\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Sistema\UsuariosBundle\Entity\Usuario;
use Sistema\UsuariosBundle\Entity\Empleado;
use Sistema\UsuariosBundle\Form\EmpleadoType;
use Sistema\FotocopiadoraBundle\Form\Empleado2Type;
use Sistema\UsuariosBundle\Entity\UsuarioRepository;

class DefaultController extends Controller
{
    public function InicioAction()
    {
        return $this->render('FotocopiadoraBundle:Default:InicioGestion.html.twig');   
    }
   
    
    public function UactivosAction()
    {
        $repository = $this->getDoctrine()->getRepository('UsuariosBundle:Usuario');
        $usuarioactivo = $repository->usuarioactivo();
       if (!$usuarioactivo) {
            $mensaje = 'No existen cuentas activas.';
            return $this->render('FotocopiadoraBundle:Default:MsjConsultaUNA.html.twig',
                    array('mensaje' => $mensaje));
       }elseif(count($usuarioactivo) == 1){
           $mensaje = 'No existen cuentas activas.';
            return $this->render('FotocopiadoraBundle:Default:MsjConsultaUNA.html.twig',
                    array('mensaje' => $mensaje));
       }
       return $this->render('FotocopiadoraBundle:Default:listaractivos.html.twig',
               array('usuarioactivo'=> $usuarioactivo));        
        
    }   
    public function DesactivarCUAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $usuarioactivo = $em->getRepository('UsuariosBundle:Usuario')->find($id);
        $usuarioactivo->setIsActive(FALSE);
        $em->persist($usuarioactivo);
        $em->flush();
       $usuarioactivo= $em->getRepository('UsuariosBundle:Usuario')->usuarioactivo();
       if (!$usuarioactivo) {
            $mensaje = 'No existen más cuentas activas.';
            return $this->render('FotocopiadoraBundle:Default:MsjConsultaUNA.html.twig',
                    array('mensaje' => $mensaje));
       }elseif (count($usuarioactivo) == 1) {
            $mensaje = 'No existen más cuentas activas.';
            return $this->render('FotocopiadoraBundle:Default:MsjConsultaUNA.html.twig',
                    array('mensaje' => $mensaje));
       }
       return $this->render('FotocopiadoraBundle:Default:listaractivos.html.twig',
               array('usuarioactivo'=> $usuarioactivo));        
    }
    
    public function UnoactivosAction()
    {
        $repository = $this->getDoctrine()->getRepository('UsuariosBundle:Usuario');
        $usuarionoactivo = $repository->usuarionoactivo();
       if (!$usuarionoactivo) {
            $mensaje = 'No existen más cuentas activas.';
            return $this->render('FotocopiadoraBundle:Default:MsjConsultaUNA.html.twig',
                    array('mensaje' => $mensaje));
       }
       return $this->render('FotocopiadoraBundle:Default:usuarionoactivo.html.twig',
               array('usuarionoactivo'=> $usuarionoactivo));        
        
    }

    public function ActivarCUAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $usuarionoactivo = $em->getRepository('UsuariosBundle:Usuario')->find($id);
        $usuarionoactivo->setIsActive(TRUE);
        $em->persist($usuarionoactivo);
        $em->flush();
       $usuarionoactivo= $em->getRepository('UsuariosBundle:Usuario')->usuarionoactivo();
       if (!$usuarionoactivo) {
           $mensaje = 'No existen más cuentas desactivadas.';
           return $this->render('FotocopiadoraBundle:Default:MsjConsultaUNA.html.twig',
                   array('mensaje' => $mensaje));
       }
       return $this->render('FotocopiadoraBundle:Default:usuarionoactivo.html.twig',
               array('usuarionoactivo'=> $usuarionoactivo));        
    }
    
        public function ActivarTCAction()
    {
       $em = $this->getDoctrine()->getManager(); 
       $usuarionoactivo= $em->getRepository('UsuariosBundle:Usuario')->usuarionoactivo2();
       foreach($usuarionoactivo as $usuarionoactivo) {
            $usuarionoactivo->setIsActive(true);
        }
        $em->persist($usuarionoactivo);
        $em->flush();
       $usuarionoactivo= $em->getRepository('UsuariosBundle:Usuario')->usuarionoactivo2();
       
        if (!$usuarionoactivo) {
            $mensaje = 'Se han activado todas las cuentas.';
            return $this->render('FotocopiadoraBundle:Default:MsjConsultaUNA.html.twig',
                    array('mensaje'=>$mensaje));
       }
       return $this->render('FotocopiadoraBundle:Default:usuarionoactivo.html.twig',
               array('usuarionoactivo'=> $usuarionoactivo));
    }
    //////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////geestion empleado/////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////
    private function setSecurePassword(&$entity) {
        $entity->setSalt(md5(time()));
        $encoder = new \Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder('sha512', true, 10);
        $password = $encoder->encodePassword($entity->getPassword(), $entity->getSalt());
        $entity->setPassword($password);
    }
    public function GestEmpleadoAction()
    {
        return $this->render('FotocopiadoraBundle:Empleado:InicioGestionEmpleado.html.twig');
    }
    public function MostrarSucAction()
    {
        $em = $this->getDoctrine()->getManager();
        $sucursal = $em->getRepository('FotocopiadoraBundle:Sucursal')->findAll();
        return $this->render('FotocopiadoraBundle:Empleado:seleccionarsucursal.html.twig', array(
            'sucursal' => $sucursal));
    }

    public function newAction($suc)
    {   
        $em = $this->getDoctrine()->getManager();
        $sucursal = $em->getRepository('FotocopiadoraBundle:Sucursal')->find($suc);
        $entity = new Empleado();
        $entity->setSucid($sucursal->getId()." - ".$sucursal->getSucNomb());
        $form   = $this->createForm(new EmpleadoType(), $entity);
        return $this->render('FotocopiadoraBundle:Empleado:nuevoempleado.html.twig', array(
            'entity' => $entity, 'form'   => $form->createView(),));
    }
    
    public function CrearusuarioAction(Request $request)
    {
        
        $entity  = new Empleado();
        if ($request->isMethod('POST')) {
            $pos = strpos($_POST['sistema_usuariosbundle_empleadotype']['sucid'], "-");
            if ($pos === false) {
                return $this->render('FotocopiadoraBundle:Empleado:mensajeerror.html.twig');
            } else {
                list($codigo, $nombre) = explode("-", $_POST['sistema_usuariosbundle_empleadotype']['sucid']);
                $form = $this->createForm(new EmpleadoType(), $entity);
                $form->bind($request);
                if ($form->isValid()) {
                    $this->setSecurePassword($entity);
                    $entity->setIsActive(TRUE);
                    $entity->setSucid($codigo);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($entity);
                    $em->flush();
                    return $this->redirect($this->generateUrl('gestion_msje'));
                }
            }            
         }
        $form   = $this->createForm(new EmpleadoType(), $entity);
        $form->bind($request);
        return $this->render('FotocopiadoraBundle:Empleado:nuevoempleado.html.twig', array(
            'entity' => $entity, 'form'   => $form->createView(),));
    }
    
    public function MsjaltaAction()
    {
//        $em = $this->getDoctrine()->getManager();
//        $entity = $em->getRepository('UsuariosBundle:Empleado')->find($id);
        return $this->render('FotocopiadoraBundle:Empleado:mensajealta.html.twig');
    }
    public function ConsultaunAction($name)
    {
        $em = $this->getDoctrine()->getManager();
        $usuario = $em->getRepository('UsuariosBundle:Usuario')->findByUsername($name);
        $cantuser = count($usuario);
        if(!$usuario){
            $mensaje = "Nombre de usuario valido.";
            $estado = 0;
        }else{
            $mensaje = "Nombre de usuario no valido.";
            $estado = 1;
        }
        return $this->render('FotocopiadoraBundle:Empleado:MsjCUE.html.twig',
                    array('mensaje' => $mensaje,
                          'cantuser' => $cantuser,
                          'estado' => $estado));
    }
    public function ConsultaemailAction($email)
    {
        $em = $this->getDoctrine()->getManager();
        $usuario = $em->getRepository('UsuariosBundle:Usuario')->findByEmail($email);
        $cantemail = count($usuario);
        if(!$usuario){
            $mensaje = "Nombre de usuario valido.";
            $estado = 0;
        }else{
            $mensaje = "Nombre de usuario no valido.";
            $estado = 1;
        }
        return $this->render('FotocopiadoraBundle:Empleado:MsjCCE.html.twig',
                    array('mensaje' => $mensaje,
                          'cantemail' => $cantemail,
                          'estado' => $estado));        
    }            

    public function ListareAction()
    {
        $repository = $this->getDoctrine()->getRepository('UsuariosBundle:Usuario');
        $empleado = $repository->empleados();
        if (!$empleado) {
            $mensaje = 'No existen empleados cargados.';
            return $this->render('FotocopiadoraBundle:Default:mensajemodif.html.twig',
                    array('mensaje' => $mensaje));
       }
        return $this->render('FotocopiadoraBundle:Empleado:modificarempleado.html.twig', array(
            'empleado' => $empleado,
        ));
    }
   
    public function EditareAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('UsuariosBundle:Usuario')->find($id);
        $editForm = $this->createForm(new Empleado2Type(), $entity);
        return $this->render('FotocopiadoraBundle:Empleado:editarE.html.twig',
                array('id' => $id, 'entity'=> $entity,
                    'edit_form'=> $editForm->createView(),));
    }
    
    public function GuardareAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('UsuariosBundle:Usuario')->find($id);
        $editForm = $this->createForm(new Empleado2Type(), $entity);
        if ($request->getMethod() == 'POST') {
        $editForm->bind($request);
            if ($editForm->isValid()) {
                $this->setSecurePassword($entity);
                $em->persist($entity);
                $em->flush();
                $mensaje = 'La contraseña se reseteo correctamente.';
                return $this->render('FotocopiadoraBundle:Empleado:mensajemodif.html.twig',
                        array('mensaje' => $mensaje));
            }
        }
        return $this->render('FotocopiadoraBundle:Empleado:editarE.html.twig',
                array('id' => $id, 'entity'=> $entity,
                    'edit_form'=> $editForm->createView(),));   
    }
    
}
