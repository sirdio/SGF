<?php

namespace Sistema\MsjinternaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Sistema\MsjinternaBundle\Models\Document;
use Sistema\MsjinternaBundle\Entity\Mensaje;
class MensajeController extends Controller
{
    
    public function MostrarFormularioAction($usn)
    {
        $em = $this->getDoctrine()->getManager();
        $datosusuario = $em->getRepository('UsuariosBundle:Profesor')->findByUsername($usn);
        //$listamaterias =$em->getRepository('UsuariosBundle:Informacionperfilprofesor')->findByUsuarioprof($datosusuario);
        $listamaterias =$em->getRepository('UsuariosBundle:Informacionperfilprofesor')->findBy
                (array('usuarioprof'=>$datosusuario, 'isActive' => 1));
        return $this->render('MsjinternaBundle:Default:formularioenvioapunte.html.twig',array(
            'lista'=>$listamaterias
        ));
    }
    
    public function EnviarApunteAction(Request $request)
    {
        echo "entro";
        die();
        $em = $this->getDoctrine()->getManager();
        if ($request->getMethod() == 'POST'){
            $datoslista = $em->getRepository('UsuariosBundle:Informacionperfilprofesor')->find($_POST['codcarrera']);
            $fechaactual = date("d-m-Y");
            $fechaactual = strtotime($fechaactual);
            $fechalista = $datoslista->getFechafinresol();
            $fechalista = strtotime($fechalista);
            if($fechalista >= $fechaactual ){              
                $nomusn = trim($_POST['usuarionombre']);
                $nomcarrera = trim($datoslista->getCarrera());
                $nommateria = trim($datoslista->getMateria());
                $docu = $request->files->get('archivo');
                if (($docu instanceof UploadedFile) && ($docu->getError() == '0')){                
                    $originalName = $docu->getClientOriginalName();
                    $name_array = explode('.', $originalName);
                    $file_type = $name_array[sizeof($name_array) - 1];
                    $valid_filetypes = array('docx','xlsx','pdf','pptx');
                    if(in_array(strtolower($file_type), $valid_filetypes)){
                        $document = new Document();
                        $document->setFile($docu);
                        $archivo2 = '/'.trim($nomusn).'/'.trim($nomcarrera).'/'.trim($nommateria);
                        $document->setSubDirectory($archivo2);
                        $document->processFile();  
                        $nuevonombre =$document->getFilePersistencePath();
                        $cadena = DIRECTORY_SEPARATOR;
                        $posicion_coincidencia = strpos($nuevonombre, $cadena);
                        $resultado = substr($nuevonombre, $posicion_coincidencia+1);
                        if ($originalName != $resultado){                                               
                            $originalName = $resultado;
                        }   
                        $datosusuario = $em->getRepository('UsuariosBundle:Profesor')->findOneByUsername($_POST['usuarionombre']);
                        $nombremitente = $datosusuario->getApellido().", ".$datosusuario->getNombre();
                        $fechaact = date("d-m-Y");
                        $entity = new Mensaje();
                        $entity->setDatomateria($datoslista);
                        $entity->setNombreremitente($nombremitente);                        
                        $entity->setAsunto($_POST['asunto']);                        
                        $entity->setDescripcion($_POST['mensaje']);
                        $entity->setFechaenvio($fechaact);
                        $entity->setPath($originalName);
                        $entity->setIsActive(1);
                        $em->persist($entity);
                        $em->flush();                                                
                    }
                    if ($_POST['boton'] == 'aceptar'){
                        $mensaje = "El Archivo se envio con exito.";
                        return $this->render('MsjinternaBundle:Default:msjdeerror.html.twig',
                            array('mensaje'=>$mensaje));                
                    }elseif($_POST['boton']== 'otro'){
                        $listamaterias =$em->getRepository('UsuariosBundle:Informacionperfilprofesor')->findBy
                            (array('usuarioprof'=>$datosusuario, 'isActive'=>1));
                        return $this->render('MsjinternaBundle:Default:formularioenvioapunte.html.twig',
                                array('lista'=>$listamaterias));                       
                    }
                }else{
                    $mensaje = "No se puede subir el archivo consulte con el administrad.";
                    return $this->render('MsjinternaBundle:Default:msjdeerror.html.twig',
                        array('mensaje'=>$mensaje)); 
                }
            } else{        
                $mensaje = "No tiene permitido enviar apuntes relacionado con la materia".$datoslista->getMateria().".Consulte con el administrador.";
                return $this->render('MsjinternaBundle:Default:msjdeerror.html.twig',
                        array('mensaje'=>$mensaje));                
            }
        }        
        $datosusuario = $em->getRepository('UsuariosBundle:Profesor')->findByUsername($_GET['usuarionombre']);
        $listamaterias =$em->getRepository('UsuariosBundle:Informacionperfilprofesor')->findBy
                (array('usuarioprof'=>$datosusuario, 'isActive'=>1));        
        return $this->render('MsjinternaBundle:Default:formularioenvioapunte.html.twig',array(
        'lista'=>$listamaterias
        ));      
    
    }
    
    public function VerApuntesAction($usn)
    {
        $em = $this->getDoctrine()->getManager();
        $datosusuario = $em->getRepository('UsuariosBundle:Profesor')->findByUsername($usn);       
        $listamaterias =$em->getRepository('UsuariosBundle:Informacionperfilprofesor')->findBy
                (array('usuarioprof'=>$datosusuario, 'isActive' => 1));
        return $this->render('MsjinternaBundle:Default:mostrarapuntes.html.twig',array(
            'lista'=>$listamaterias
        ));        
        
    }
    
    public function ListarApunteAction($lid)
    {
        $em = $this->getDoctrine()->getManager();
        $listamaterias =$em->getRepository('UsuariosBundle:Informacionperfilprofesor')->find($lid);        
        $fid = $listamaterias->getFacultad()->getFacCodigo();
        $cid = $listamaterias->getCarrera()->getCarrCodigo();
        $mid = $listamaterias->getMateria()->getMatCodigo();
        $facultad = $this->getObtenerFacultad($fid);
        $carrera = $this->getObtenerCarrera($cid);
        $materia = $this->getObtenerMateria($mid);
        $listaapuntes =$em->getRepository('FotocopiadoraBundle:Apunte')->findBy
                (array('facultad_id'=> $fid, 'carrera_id'=> $cid, 'materia_id'=> $mid));  
        $cantidad = count($listaapuntes);
        if (count($listaapuntes)== 0){
            $mensaje = "No hay apuntes cargados para esa materia.";
            return $this->render('MsjinternaBundle:Default:listarapunte.html.twig',array(
                'mensaje'=>$mensaje, 'cantidad'=>$cantidad));
        }else{
            return $this->render('MsjinternaBundle:Default:listarapunte.html.twig',array(
                'lista'=>$listaapuntes, 'facultad'=>$facultad, 'carrera'=>$carrera,
                'materia'=>$materia, 'cantidad'=>$cantidad));
        }
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
    
    public function DescargarApunteAction($fId)            
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FotocopiadoraBundle:Apunte')->find($fId);
        $cfac = $entity->getFacultadId();
        $ccarr = $entity->getCarreraId();
        $cmat = $entity->getMateriaId();
        $facultad = $em->getRepository('FacultadBundle:Facultad')->find($cfac);
        $facdirec =$facultad->getFacNombre();
        $carrera = $em->getRepository('FacultadBundle:Carrera')->find($ccarr);
        $carrdirec = $carrera->getCarrNombre();
        $materia = $em->getRepository('FacultadBundle:Materia')->find($cmat);
        $matdirec =$materia->getMatNombre();
        $filename = $entity->getPath();
        $vec = explode('.', $filename);
        $extension = $vec[1];  
        $response = new Response(); 
        header('Content-type: application/'.$extension);
        $response->headers->set('Content-Disposition', 'attachment; filename=' . basename($filename) );
        $response->headers->set('Pragma', "no-cache");
        $response->headers->set('Expires', "0");
        $response->headers->set('Content-Transfer-Encoding', "binary");
        $response->sendHeaders();
        $response->setContent(readfile($this->get('kernel')->getRootDir().'/../web/documentos'.'/'.$facdirec.'/'.$carrdirec.'/'.$matdirec.'/'.$filename));
        return $response;        
    }
    public function MensajesIntAction($usn)
    {
        $em = $this->getDoctrine()->getManager();
        $datosusuario = $em->getRepository('UsuariosBundle:Empleado')->findOneByUsername($usn);
        if($datosusuario->getTipou() == "Empleado" || $datosusuario->getTipou() == "Administrador"){
            $datosmsj = $em->getRepository('MsjinternaBundle:Mensaje')->findAll();
            return $this->render('MsjinternaBundle:Mensajesinterno:mensajesinterno.html.twig',
                        array('msjint'=>$datosmsj));                        
           
        }else{
            $mensaje = "Usted no tiene permisos para ver los mensajes.";
            return $this->render('MsjinternaBundle:Mensajesinterno:msjdeerror.html.twig',
                        array('mensaje'=>$mensaje));            
        }
    }
    
    public function VerMsjAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $datosmsj = $em->getRepository('MsjinternaBundle:Mensaje')->find($id);
        $facultad = $datosmsj->getDatomateria()->getFacultad();
        $carrera = $datosmsj->getDatomateria()->getCarrera();
        $materia = $datosmsj->getDatomateria()->getMateria();
        $datosmsj->setIsActive(0);
        $em->persist($datosmsj);
        $em->flush();
        return $this->render('MsjinternaBundle:Mensajesinterno:vermsj.html.twig',
               array('datosmsj'=>$datosmsj, 'facultad'=>$facultad,
                   'carrera'=>$carrera, 'materia'=>$materia));            
    }
    
    public function DescargarArchivoAction($id)            
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('MsjinternaBundle:Mensaje')->find($id);
        $perfilid = $entity->getDatomateria()->getId();
        $carrdirec = $entity->getDatomateria()->getCarrera();
        $matdirec = $entity->getDatomateria()->getMateria();
        $datouser = $em->getRepository('UsuariosBundle:Informacionperfilprofesor')->find($perfilid);
        $direcuser = $datouser->getUsuarioprof()->getUsername();
        $filename = $entity->getPath();
        $vec = explode('.', $filename);
        $extension = $vec[1];  
        $response = new Response(); 
        header('Content-type: application/'.$extension);
        $response->headers->set('Content-Disposition', 'attachment; filename=' . basename($filename) );
        $response->headers->set('Pragma', "no-cache");
        $response->headers->set('Expires', "0");
        $response->headers->set('Content-Transfer-Encoding', "binary");
        $response->sendHeaders();
        $response->setContent(readfile($this->get('kernel')->getRootDir().'/../web/archivosmsj'.'/'.$direcuser.'/'.$carrdirec.'/'.$matdirec.'/'.$filename));
        return $response;        
    }    
}