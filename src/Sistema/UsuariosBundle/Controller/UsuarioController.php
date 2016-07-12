<?php

namespace Sistema\UsuariosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sistema\UsuariosBundle\Entity\Usuario;
use Sistema\UsuariosBundle\Entity\Alumno;
use Sistema\UsuariosBundle\Entity\Informacionperfiles;
use Sistema\UsuariosBundle\Entity\Informacionperfilprofesor;
use Sistema\UsuariosBundle\Form\AlumnoType;
use Sistema\UsuariosBundle\Form\AlumnocelType;
use Sistema\UsuariosBundle\Form\AlumnoaynType;
use Sistema\UsuariosBundle\Form\AlumnopassType;
use Sistema\UsuariosBundle\Form\EmpleadoaynType;
use Sistema\UsuariosBundle\Form\EmpleadocelType;
use Sistema\UsuariosBundle\Form\EmpleadosucType;
use Sistema\UsuariosBundle\Form\EmpleadopassType;
use Sistema\UsuariosBundle\Entity\Profesor;
use Sistema\UsuariosBundle\Form\ProfesorType;
use Sistema\UsuariosBundle\Form\ProfesoraynType;
use Sistema\UsuariosBundle\Form\ProfesorcelType;
use Sistema\UsuariosBundle\Form\ProfesorpassType;
use Sistema\UsuariosBundle\Form\UsuarioType;
use Sistema\UsuariosBundle\Entity\TipoUsuario;
use Sistema\UsuariosBundle\Entity\TipoUsuarioRepository;
use Sistema\FacultadBundle\Entity\Facultad;
class UsuarioController extends Controller
{



    public function createAction(Request $request)
    {
        foreach($_POST as $nombre => $valor){
            $nomb = $nombre;       
        }
        if($nomb =='sistema_usuariosbundle_alumnotype'){
            $entity  = new Alumno();
            $form = $this->createForm(new AlumnoType(), $entity);
            $form->bind($request);            
            if ($entity->getTipou()->getName()== "Alumno") {
                if ($request->getMethod() == 'POST'){
                    if ($form->isValid()) {
                        $this->setSecurePassword($entity);
                        $this->setCrearCuenta($entity);                
                        $em = $this->getDoctrine()->getManager();
                        $em->persist($entity);
                        $em->flush();                        
                        return $this->redirect($this->generateUrl('usuario_login'));
                    }
                    return $this->render('UsuariosBundle:Usuario:newalumno.html.twig', array(
                           'entity' => $entity, 'form'  => $form->createView(),));  
                }                 
                return $this->render('UsuariosBundle:Usuario:newalumno.html.twig', array(
                       'entity' => $entity, 'form'  => $form->createView(),));
                
            }else{
                return $this->render('UsuariosBundle:Usuario:MsjAlta.html.twig');
            }
        }
        if($nomb =='sistema_usuariosbundle_profesortype'){
            $entity  = new Profesor();
            $form = $this->createForm(new ProfesorType(), $entity);
            $form->bind($request);             
            if ($entity->getTipou()->getName()== "Profesor") {                                
                 if ($request->getMethod() == 'POST'){
                    $fecha = date("d-m-Y");
                    $entity->setFechacreacion($fecha);
                    $entity->setFechaultmod($fecha);                     
                    if ($form->isValid()) {
                        $this->setSecurePassword($entity);                
                        $em = $this->getDoctrine()->getManager();
                        $em->persist($entity);
                        $em->flush();
                        return $this->redirect($this->generateUrl('usuario_login'));
                    }
                    return $this->render('UsuariosBundle:Usuario:newprofesor.html.twig', array(
                           'entity' => $entity, 'form'  => $form->createView(),));                    
                    
                }                   
                return $this->render('UsuariosBundle:Usuario:newprofesor.html.twig', array(
                       'entity' => $entity, 'form'  => $form->createView(),));                 
                 
                 
            }else{
                return $this->render('UsuariosBundle:Usuario:MsjAlta.html.twig');
            }           
        } 
        
    }
    
    public function TipoUserAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('UsuariosBundle:TipoUsuario')->tipousuario1();
        return $this->render('UsuariosBundle:TipoUsuario:mostrartipousuario.html.twig', array(
            'entity' => $entity,
        ));        
    }

    public function newAction($tipou)
    {
        $em = $this->getDoctrine()->getManager();        
        $tipousuario = $em->getRepository('UsuariosBundle:TipoUsuario')->find($tipou);        
        if( $tipousuario->getName() == "Alumno"){
            $entity = new Alumno();
            $entity->setTipou($tipousuario);
            $form = $this->createForm(new AlumnoType(),$entity);
             return $this->render('UsuariosBundle:Usuario:new.html.twig', array(
                'entity' => $entity, 'form' => $form->createView(),));
        }elseif($tipousuario->getName() == "Profesor") {
            $entity = new Profesor();
            $entity->setTipou($tipousuario);
            $form = $this->createForm(new ProfesorType(),$entity);
            return $this->render('UsuariosBundle:Usuario:new1.html.twig', array(
                'entity' => $entity, 'form' => $form->createView(),));                   
        }else{
            return $this->redirect($this->generateUrl('usuario_login'));
        }
    }



    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UsuariosBundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new UsuarioType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $this->setSecurePassword($entity);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('usuario_edit', array('id' => $id)));
        }

        return $this->render('UsuariosBundle:Usuario:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


     private function setSecurePassword(&$entity) {
        $entity->setSalt(md5(time()));
        $encoder = new \Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder('sha512', true, 10);
        $password = $encoder->encodePassword($entity->getPassword(), $entity->getSalt());
        $entity->setPassword($password);
    }
    
    private function setCrearCuenta(&$entity){
        $entity->setNrocuenta($entity->getNroLU().$entity->getAnioIng());
    }

    public function VerPerfilAction($usn)
    {
        $em = $this->getDoctrine()->getManager();
        $datouser = $em->getRepository('UsuariosBundle:Usuario')->findOneByUsername($usn);
        $tipouser = $datouser->getTipou()->getName();                
        if($tipouser == "Alumno"){
            $datosusuario = $em->getRepository('UsuariosBundle:Alumno')->findOneByUsername($usn);
            return $this->render('UsuariosBundle:Usuario:perfildeusuario.html.twig', array('datosusuario' => $datosusuario));
        }else if($tipouser == "Profesor"){
            $datosusuario = $em->getRepository('UsuariosBundle:Profesor')->findOneByUsername($usn);
            return $this->render('UsuariosBundle:Usuario:perfilprofesor.html.twig', array('datosusuario' => $datosusuario));
        }else if($tipouser == "Empleado" || $tipouser == "Administrador"){
            $datosusuario = $em->getRepository('UsuariosBundle:Empleado')->findOneByUsername($usn);
            $datossucursal = $this->getObtenerSucursal($datosusuario->getSucid());
            return $this->render('UsuariosBundle:Usuario:perfilusuarioempleado.html.twig', 
                    array('datosusuario' => $datosusuario,'tipouser'=>$tipouser, 'datossucursal' => $datossucursal));
        }else {
            $mensaje = "Existe un problema al intentar acceder a su perfil, de continuar el problema por favos consulte con el administrador.";
            return $this->render('UsuariosBundle:Usuario:msjerroperfil.html.twig', array('mensaje' => $mensaje,'tipouser'=>$tipouser));
        };
        
    }
    
    public function ActualizarCelAction(Request $request, $usn)
    {

        $datosusuario = $this->getObtenerUsuario($usn);
        $editForm = $this->createForm(new AlumnocelType(), $datosusuario);
        if ($request->isMethod('POST')) {
            $editForm->bind($request);
            if ($editForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($datosusuario);
                $em->flush();
                $datosusuario = $this->getObtenerUsuario($usn);
                return $this->render('UsuariosBundle:Usuario:perfildeusuario.html.twig', 
                        array('datosusuario' => $datosusuario));
            }
        }
        return $this->render('UsuariosBundle:Usuario:modificarcel.html.twig', array(
            'datosusuario'      => $datosusuario,
            'edit_form'   => $editForm->createView(),            
        ));
    }
    public function ActualizarAyNAction(Request $request, $usn)
    {

        $datosusuario = $this->getObtenerUsuario($usn);
        $editForm = $this->createForm(new AlumnoaynType(), $datosusuario);
        if ($request->isMethod('POST')) {
            $editForm->bind($request);
            if ($editForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($datosusuario);
                $em->flush();
                $datosusuario = $this->getObtenerUsuario($usn);
                return $this->render('UsuariosBundle:Usuario:perfildeusuario.html.twig', 
                        array('datosusuario' => $datosusuario));
            }
        }        
        return $this->render('UsuariosBundle:Usuario:modificarayn.html.twig', array(
            'datosusuario'      => $datosusuario,
            'edit_form'   => $editForm->createView(),            
        ));        
    }
    
    public function ActualizarPassAction(Request $request, $usn)
    {
        $datosusuario = $this->getObtenerUsuario($usn);
        $editForm = $this->createForm(new AlumnopassType(), $datosusuario);
        
        if ($request->isMethod('POST')) {
            $editForm->bind($request);
            if ($editForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $this->setSecurePassword($datosusuario);
                $em->persist($datosusuario);
                $em->flush();
                $datosusuario = $this->getObtenerUsuario($usn);
                return $this->render('UsuariosBundle:Usuario:perfildeusuario.html.twig', 
                        array('datosusuario' => $datosusuario));
            }
        }        
        return $this->render('UsuariosBundle:Usuario:modificarpass.html.twig', array(
            'datosusuario'      => $datosusuario,
            'edit_form'   => $editForm->createView(),            
        ));        
    } 
    
    public function getObtenerUsuario($usn)
    {
        $em = $this->getDoctrine()->getManager();
        $datosusuario = $em->getRepository('UsuariosBundle:Alumno')->findOneByUsername($usn);
        return $datosusuario;
    } 
    public function getObtenerFacultad($fid)
    {
        $em = $this->getDoctrine()->getManager();
        $datoFacultad = $em->getRepository('FacultadBundle:Facultad')->find($fid);        
        return $datoFacultad;
    } 
    public function getObtenerCarrera($cid)
    {
        $em = $this->getDoctrine()->getManager();
        $datoCarrera = $em->getRepository('FacultadBundle:Carrera')->find($cid);
        return $datoCarrera;
    }    
    public function getObtenerMateria($maid)
    {
        $em = $this->getDoctrine()->getManager();
        $datoMateria = $em->getRepository('FacultadBundle:Materia')->find($maid);
        return $datoMateria;
    }    
    public function VerInfMatAction($usn)
    {   
        $datosusuario = $this->getObtenerUsuario($usn);
        $em = $this->getDoctrine()->getManager();
        $infomaterias = $em->getRepository('UsuariosBundle:Informacionperfiles')->findByUsuarioalu($datosusuario);
        if(!$infomaterias){
            $mensaje = "No existen materias seleccionadas.";     
            return $this->render('UsuariosBundle:Usuario:msjinfo.html.twig', array(
            'mensaje' => $mensaje, 'usn' => $usn,  )); 
        }
        $cantidad = count($infomaterias);
        $estado = 1; 
        return $this->render('UsuariosBundle:Usuario:VerInformaciondematerias.html.twig', array(
            'infomaterias' => $infomaterias, 'cantidad' => $cantidad, 'estado' => $estado,
            'usn' => $usn,
        )); 
 
         
    }
    
    public function AgregarMatAction($usn)
    {
        $em = $this->getDoctrine()->getManager();
        $facultad = $em->getRepository('FacultadBundle:Facultad')->findAll();
        $form = $this->createForm(new \Sistema\FacultadBundle\form\MostrarFType() , $facultad);
        return $this->render('UsuariosBundle:Usuario:agregarmaterialist.html.twig', array(
            'facultad'=>$facultad,
            'form'   => $form->createView(),
        ));         
        
    }
    public function AgregarListaAction($fid, $cid, $maid, $usn)
    {
    
        $datosusuario = $this->getObtenerUsuario($usn);
        $datosfacultad = $this->getObtenerFacultad($fid);
        $datoscarrera = $this->getObtenerCarrera($cid);
        $datosmateria = $this->getObtenerMateria($maid);
        $em = $this->getDoctrine()->getManager();
        $listamateria = $em->getRepository('UsuariosBundle:Informacionperfiles')->findByUsuarioalu($datosusuario);
        $cantidad = count($listamateria);
        if($cantidad <= 4){
            $listamateria = new Informacionperfiles();
            $listamateria->setFacultad($datosfacultad);
            $listamateria->setCarrera($datoscarrera);
            $listamateria->setMateria($datosmateria);
            $listamateria->setUsuarioalu($datosusuario);
            $em->persist($listamateria);
            $em->flush();
            $estado = 2;
            $mensaje = "Los Datos se agregaron con exito.";
//            echo $mensaje;
//            die();
            return $this->render('UsuariosBundle:Usuario:VerInformaciondematerias.html.twig', array(
                'facultad'=>$datosfacultad, 'carrera'=>$datoscarrera, 'cantidad'=> $cantidad,
                'materia'=>$datosmateria, 'estado' => $estado, 'mensaje' => $mensaje, 'usn' => $usn,
            ));                        
        }else{
            echo "no es menor";
            die();            
        }

    }
    public function ModificarlistAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $datoslista = $em->getRepository('UsuariosBundle:Informacionperfiles')->find($id);
        $carrera = $em->getRepository('FacultadBundle:Carrera')->findAll();
        
        return $this->render('UsuariosBundle:Vistasfmc:vistamodificar.html.twig',
                array('carrera' => $carrera,'datoslista' => $datoslista));
        
    }
    public function MostMateriaAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $carrera = $em->getRepository('FacultadBundle:Carrera')->find($id);
        $materias = $carrera->getCarreraMaterias();   
        return $this->render('UsuariosBundle:Vistasfmc:mostmateria.html.twig',
                array('materias'=>$materias));        
    }
    
    public function DatosSelecaluAction($cid, $maid, $pid)
    {
        $em = $this->getDoctrine()->getManager();
        $carrera = $em->getRepository('FacultadBundle:Carrera')->find($cid);
        $facultad = $carrera->getFacultad()->getFacNombre();    
        $fid = $carrera->getFacultad()->getFacCodigo();    
        $materia = $em->getRepository('FacultadBundle:Materia')->find($maid);
        return $this->render('UsuariosBundle:Vistasfmc:mostdatos.html.twig',
        array('facultad'=>$facultad, 'carrera'=>$carrera,'materia'=>$materia, 
            'pid'=>$pid, 'fid'=>$fid));  
    }
    public function GuardardlaluAction($pid, $fid, $cid, $maid)
    {
        $facultad = $this->getObtenerFacultad($fid);
        $carrera = $this->getObtenerCarrera($cid);
        $materia = $this->getObtenerMateria($maid);
        $em = $this->getDoctrine()->getManager();
        $datoslista = $em->getRepository('UsuariosBundle:Informacionperfiles')->find($pid);
        $datoslista->setFacultad($facultad);
        $datoslista->setCarrera($carrera);
        $datoslista->setMateria($materia);
        $em->persist($datoslista);
        $em->flush();
        $mensaje = "Los datos se guardaron con exito.";
        return $this->render('UsuariosBundle:Vistasfmc:mensajevista.html.twig',
                array('mensaje'=>$mensaje));
    }
    
    public function ModDatosEmpAction(Request $request,$usn, $codop)
    {
        $datosusuario = $this->getObtenerUsuarioempleado($usn);
        $tipouser = $datosusuario->getTipou()->getName();
        if($codop == "cel"){
            $editForm = $this->createForm(new EmpleadocelType(), $datosusuario);
            if ($request->isMethod('POST')) {
                $editForm->bind($request);
                if ($editForm->isValid()) {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($datosusuario);
                    $em->flush();
                    $datosusuario = $this->getObtenerUsuarioempleado($usn);
                     $datossucursal=$this->getObtenerSucursal($datosusuario->getSucid());
                    return $this->render('UsuariosBundle:Usuario:perfilusuarioempleado.html.twig', 
                            array('datosusuario' => $datosusuario,'tipouser'=>$tipouser, 'datossucursal'=>$datossucursal));
                }
            }
            return $this->render('UsuariosBundle:Perfilempleado:modificarcelempleado.html.twig', array(
                'datosusuario'      => $datosusuario, 'tipouser'=>$tipouser,'edit_form'   => $editForm->createView(),)); 
        }elseif($codop == "pas"){
            $editForm = $this->createForm(new EmpleadopassType(), $datosusuario);
            if ($request->isMethod('POST')) {
                $editForm->bind($request);
                if ($editForm->isValid()) {
                    $em = $this->getDoctrine()->getManager();
                    $this->setSecurePassword($datosusuario);
                    $em->persist($datosusuario);
                    $em->flush();
                    $datosusuario = $this->getObtenerUsuarioempleado($usn);
                    $datossucursal=$this->getObtenerSucursal($datosusuario->getSucid());
                    return $this->render('UsuariosBundle:Usuario:perfilusuarioempleado.html.twig', 
                            array('datosusuario' => $datosusuario,'tipouser'=>$tipouser,'datossucursal'=>$datossucursal));
                }
            }
            return $this->render('UsuariosBundle:Perfilempleado:modificarpassempleado.html.twig', array(
                'datosusuario'      => $datosusuario, 'tipouser'=>$tipouser, 'edit_form'   => $editForm->createView(),)); 
        }elseif($codop == "ayn"){
            $editForm = $this->createForm(new EmpleadoaynType(), $datosusuario);
            if ($request->isMethod('POST')) {
                $editForm->bind($request);
                if ($editForm->isValid()) {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($datosusuario);
                    $em->flush();
                    $datosusuario = $this->getObtenerUsuarioempleado($usn);
                    $datossucursal=$this->getObtenerSucursal($datosusuario->getSucid());
                  
                    return $this->render('UsuariosBundle:Usuario:perfilusuarioempleado.html.twig', 
                            array('datosusuario' => $datosusuario,'tipouser'=>$tipouser, 'datossucursal'=>$datossucursal));
                }
            }
            return $this->render('UsuariosBundle:Perfilempleado:modificaraynempleado.html.twig', array(
                'datosusuario'      => $datosusuario, 'tipouser'=>$tipouser, 'edit_form'   => $editForm->createView(),)); 
        }elseif($codop == "suc"){        
            $em = $this->getDoctrine()->getManager();
            $sucursal = $em->getRepository('FotocopiadoraBundle:Sucursal')->findAll();
            if ($request->isMethod('POST')) {                
                $codsuc = $_POST['sucursal'];    
                $datossucursal = $this->getObtenerSucursal($codsuc);
                $datosusuario->setSucid($codsuc);
                $em = $this->getDoctrine()->getManager();
                $em->persist($datosusuario);
                $em->flush();
                $datosusuario = $this->getObtenerUsuarioempleado($usn);
                return $this->render('UsuariosBundle:Usuario:perfilusuarioempleado.html.twig', 
                            array('datosusuario' => $datosusuario,'tipouser'=>$tipouser, 'datossucursal'   => $datossucursal));                
            }
            return $this->render('UsuariosBundle:Perfilempleado:modificarsucempleado.html.twig', array(
                'datosusuario'      => $datosusuario, 'sucursal'   => $sucursal, 'tipouser'=>$tipouser,)); 
        }else{
            echo"error";
            die();
        }
        
    }
    public function getObtenerUsuarioempleado($usn)
    {
        $em = $this->getDoctrine()->getManager();
        $datosusuario = $em->getRepository('UsuariosBundle:Empleado')->findOneByUsername($usn);
        return $datosusuario;
    } 
    
    public function getObtenerSucursal($idsuc)
    {
        $em = $this->getDoctrine()->getManager();
        $datossucursal = $em->getRepository('FotocopiadoraBundle:Sucursal')->find($idsuc);
        return $datossucursal;
    }  

    public function ModDatosProfAction(Request $request,$usn, $codop)
    {
        $datosusuario = $this->getObtenerUsuarioprofesor($usn);
        if($codop == "cel"){
            $editForm = $this->createForm(new ProfesorcelType(), $datosusuario);
            if ($request->isMethod('POST')) {
                $editForm->bind($request);
                if ($editForm->isValid()) {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($datosusuario);
                    $em->flush();
                    $datosusuario = $this->getObtenerUsuarioprofesor($usn);
                    return $this->render('UsuariosBundle:Usuario:perfilprofesor.html.twig', 
                            array('datosusuario' => $datosusuario));
                }
            }
            return $this->render('UsuariosBundle:Perfilprofesor:modificarprofesor.html.twig', array(
                'datosusuario' => $datosusuario, 'codop'=>$codop,'edit_form' => $editForm->createView(),)); 
        }elseif($codop == "pas"){
            $editForm = $this->createForm(new ProfesorpassType(), $datosusuario);
            if ($request->isMethod('POST')) {
                $editForm->bind($request);
                if ($editForm->isValid()) {
                    $em = $this->getDoctrine()->getManager();
                    $this->setSecurePassword($datosusuario);
                    $em->persist($datosusuario);
                    $em->flush();
                    $datosusuario = $this->getObtenerUsuarioprofesor($usn);
                    return $this->render('UsuariosBundle:Usuario:perfilprofesor.html.twig', 
                            array('datosusuario' => $datosusuario));
                }
            }
            return $this->render('UsuariosBundle:Perfilprofesor:modificarprofesor.html.twig', array(
                'datosusuario' => $datosusuario, 'codop'=>$codop,'edit_form' => $editForm->createView(),)); 
        }elseif($codop == "ayn"){
            $editForm = $this->createForm(new ProfesoraynType(), $datosusuario);
            if ($request->isMethod('POST')) {
                $editForm->bind($request);
                if ($editForm->isValid()) {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($datosusuario);
                    $em->flush();
                    $datosusuario = $this->getObtenerUsuarioprofesor($usn);              
                    return $this->render('UsuariosBundle:Usuario:perfilprofesor.html.twig', 
                            array('datosusuario' => $datosusuario));
                }
            }
            return $this->render('UsuariosBundle:Perfilprofesor:modificarprofesor.html.twig', array(
                'datosusuario' => $datosusuario, 'codop'=>$codop,'edit_form' => $editForm->createView(),)); 
        }elseif($codop == "lis"){ 

            $em = $this->getDoctrine()->getManager();
            $datosperfil = $em->getRepository('UsuariosBundle:Informacionperfilprofesor')->findByUsuarioprof($datosusuario);
            $cantidad = count($datosperfil);

            if ($cantidad == 0){
                $mensaje = "La lista esta vacia.";
                return $this->render('UsuariosBundle:Perfilprofesor:listamateriaprofesor.html.twig', array(
                'cant' => $cantidad, 'mensaje' => $mensaje)); 
            }else{
                return $this->render('UsuariosBundle:Perfilprofesor:listamateriaprofesor.html.twig', array(
                'infoperfil' => $datosperfil, 'cant' => $cantidad));                 
            }
        }else{
            echo"error";
            die();
        }
  }
  public function getObtenerUsuarioprofesor($usn)
  {
        $em = $this->getDoctrine()->getManager();
        $datosusuario = $em->getRepository('UsuariosBundle:Profesor')->findOneByUsername($usn);
        return $datosusuario;
  } 
  public function CargarPerfilAction(Request $request,$usn)
  {      
      $em = $this->getDoctrine()->getManager();
      $carrera = $em->getRepository('FacultadBundle:Carrera')->findAll();
      if ($request->isMethod('POST')) {                
          $carrera = $this->getObtenerCarrera($_POST['codcarrera']);
          $materia = $this->getObtenerMateria($_POST['codmateria']);
          $fid = $carrera->getFacultad()->getFacCodigo();
          $facultad = $this->getObtenerFacultad($fid);          
          $datosusuario = $this->getObtenerUsuarioprofesor($usn);
          $infoperfil = new Informacionperfilprofesor();
          $infoperfil->setFacultad($facultad);
          $infoperfil->setCarrera($carrera);
          $infoperfil->setMateria($materia);
          $infoperfil->setNroresolucion($_POST['resolucion']);
          $infoperfil->setFechafinresol($_POST['fechavencimiento']);
          $infoperfil->setUsuarioprof($datosusuario);
          $infoperfil->setIsActive(1);
          $em = $this->getDoctrine()->getManager();
          $em->persist($infoperfil);
          $em->flush();        
          return $this->render('UsuariosBundle:Usuario:perfilprofesor.html.twig', 
            array('datosusuario' => $datosusuario));                                      
      }      
      return $this->render('UsuariosBundle:Perfilprofesor:Formularioperfil.html.twig',array(
          'carrera'=>$carrera, 'usn'=>$usn));
  }
  public function ObtenerMateriaAction($cid)
  {     
      $carrera = $this->getObtenerCarrera($cid);      
      $materia = $carrera->getCarreraMaterias();
      return $this->render('UsuariosBundle:Perfilprofesor:selecmateria.html.twig',array(
          'materia'=>$materia));     
  }
  
  public function ModificarlistprofAction(Request $request,$id, $usn)
  {
      $em = $this->getDoctrine()->getManager();
      $infoperfil = $em->getRepository('UsuariosBundle:Informacionperfilprofesor')->find($id);
      //$carrera = $em->getRepository('FacultadBundle:Carrera')->findAll();
      if ($request->isMethod('POST')) {   
          //$carrera = $this->getObtenerCarrera($_POST['codcarrera']);
          //$materia = $this->getObtenerMateria($_POST['codmateria']);
          //$fid = $carrera->getFacultad()->getFacCodigo();
          //$facultad = $this->getObtenerFacultad($fid);          
          $datosusuario = $this->getObtenerUsuarioprofesor($usn);
          //$infoperfil->setFacultad($facultad);
          //$infoperfil->setCarrera($carrera);
          //$infoperfil->setMateria($materia);
          $infoperfil->setNroresolucion($_POST['resolucion']);
          $infoperfil->setFechafinresol($_POST['fechavencimiento']);
          $infoperfil->setUsuarioprof($datosusuario);
          $infoperfil->setIsActive(1);
          $em = $this->getDoctrine()->getManager();
          $em->persist($infoperfil);
          $em->flush();        
          return $this->render('UsuariosBundle:Usuario:perfilprofesor.html.twig', 
            array('datosusuario' => $datosusuario));                                      
      }      
      return $this->render('UsuariosBundle:Perfilprofesor:Formularioeditperfil.html.twig',array(
          //'carrera'=>$carrera, 
          'infoperfil'=>$infoperfil));  
  }
  
  public function MostrarApuntesAction($usn)
  {
        $em = $this->getDoctrine()->getManager();
        $alumno = $em->getRepository('UsuariosBundle:Usuario')->findByUsername($usn);
        $infomateria = $em->getRepository('UsuariosBundle:Informacionperfiles')->findByUsuarioalu($alumno);
        
        $i =1;
        foreach($infomateria as $infomateria){
            $apunte = $em->getRepository('FotocopiadoraBundle:Apunte')->findBy(
                    array( 'facultad_id'  => $infomateria->getFacultad()->getFacCodigo(),
                        'carrera_id' => $infomateria->getCarrera()->getCarrCodigo(),
                         'materia_id' => $infomateria->getMateria()->getMatCodigo()));
            if (count($apunte)!= 0){
                foreach($apunte as $apunte){
                    $apuntes[$i]=array( 'nombre'=>$apunte->getNombre(),
                    'carrera'=>$infomateria->getCarrera()->getCarrCodigo(),
                    'materia'=>$infomateria->getMateria()->getMatCodigo(),
                    'fecha'=>$apunte->getFecha(),
                    'precio'=>$apunte->getPrecio(),
                    'observ'=>$apunte->getObservacion());
                    $i++;                    
                }
            }
            

        }
        if (count($apuntes) == 0){
            $i =1;
            $apunte = $em->getRepository('FotocopiadoraBundle:Apunte')->findAll();
            foreach($apunte as $apunte){
                $apuntes[$i]=array( 'nombre'=>$apunte->getNombre(),
                'carrera'=>$apunte->getCarreraId(),
                'materia'=>$apunte->getMateriaId(),
                'fecha'=>$apunte->getFecha(),
                'precio'=>$apunte->getPrecio(),
                'observ'=>$apunte->getObservacion());
                $i++;                    
            }
            for($i = 1; $i < 4; $i++){
                $j = rand(1, count($apuntes));
                $lista[$i] = $apuntes[$j];
            }             
        }elseif(count($apuntes)> 0 and count($apuntes) < 4 ){
            $lista = $apuntes;            
        }elseif(count($apuntes)> 3){
            for($i = 1; $i < 4; $i++){
                $j = rand(1, count($apuntes));
                $lista[$i] = $apuntes[$j];
            }            
        };
        
        return $this->render('UsuariosBundle:Usuario:listarmateriadeinteres.html.twig', 
            array('lista' => $lista));                                                   
  }
}
?>
