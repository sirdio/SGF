<?php

namespace Sistema\FotocopiadoraBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sistema\FacultadBundle\Entity\Facultad;
use Sistema\FacultadBundle\Entity\FacultadRepository;
use Sistema\FotocopiadoraBundle\Entity\Apunte;
use Sistema\PedidoBundle\Entity\Pedidodet;
use Sistema\FotocopiadoraBundle\Form\ApunteType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Sistema\FotocopiadoraBundle\Models\Document;

/**
 * Apunte controller.
 *
 * @Route("/apunte")
 */
class ApunteController extends Controller
{
    /**
     * Lists all Apunte entities.
     *
     * @Route("/", name="apunte")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FotocopiadoraBundle:Apunte')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Apunte entity.
     *
     * @Route("/", name="apunte_create")
     * @Method("POST")
     * @Template("FotocopiadoraBundle:Apunte:new.html.twig")
     */
    public function createAction(Request $request, $tus)
    {
        if ($request->getMethod() == 'POST')
        {
            $nomfac = explode('-', $_POST['facultad_id']);    
            $nomcarr = explode('-', $_POST['carrera_id']);    
            $nommat = explode('-', $_POST['materia_id']);           
            $docu = $request->files->get('archivo');
            if (($docu instanceof UploadedFile) && ($docu->getError() == '0')) 
             {
                
                $originalName = $docu->getClientOriginalName();
                $name_array = explode('.', $originalName);
                $file_type = $name_array[sizeof($name_array) - 1];
                $valid_filetypes = array('docx','xlsx','pdf','pptx');
   
                if(in_array(strtolower($file_type), $valid_filetypes))
                {
                    $document = new Document();
                    $document->setFile($docu);
                    $archivo2 = '/'.trim($nomfac[1]).'/'.trim($nomcarr[1]).'/'.trim($nommat[1]);
                    $document->setSubDirectory($archivo2);
                    $document->processFile();  
                    
                    $nuevonombre =$document->getFilePersistencePath();
                    $cadena = DIRECTORY_SEPARATOR;
                    $posicion_coincidencia = strpos($nuevonombre, $cadena);
                    $resultado = substr($nuevonombre, $posicion_coincidencia+1);
                    if ($originalName != $resultado){                                               
                        $originalName = $resultado;
                    }   

                    $entity = new Apunte();
                    $entity->setNombre($_POST['nombre']);
                    $entity->setFecha($_POST['datepicker']);
                    $entity->setNropag($_POST['nropag']);
                    $entity->setPrecio($_POST['precio']);
                    $entity->setObservacion($_POST['observacion']);
                    $entity->setFacultadId($nomfac[0]);
                    $entity->setCarreraId($nomcarr[0]);
                    $entity->setMateriaId($nommat[0]);
                    $entity->setPath($originalName);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($entity);
                    $em->flush();
                    $facultad = $em->getRepository('FacultadBundle:Facultad')->find($nomfac[0]);
                    $carrera = $em->getRepository('FacultadBundle:Carrera')->find($nomcarr[0]);
                    $materia = $em->getRepository('FacultadBundle:Materia')->find($nommat[0]);
                    if ($_POST['boton'] == 'Nuevo')
                    {
                        if($tus == "Empleado"){
                            return $this->redirect($this->generateUrl('G_buscaremp'));
                        }elseif($tus == "Administrador"){
                            return $this->redirect($this->generateUrl('G_buscar'));
                        }
                        
                    }elseif($_POST['boton']== 'Otro'){
                        return $this->render('FotocopiadoraBundle:Apunte:new1.html.twig', array(
                            'facultad' => $facultad,
                            'carrera' => $carrera,
                            'materia' => $materia,));  
                    }
                        
                }else{
                        if($tus == "Empleado"){
                            return $this->redirect($this->generateUrl('G_buscaremp'));
                        }elseif($tus == "Administrador"){
                            return $this->redirect($this->generateUrl('G_buscar'));
                        }
                }
                
            }else{
                die('ERROR');
            }
            }

    }

    /**
     * Displays a form to create a new Apunte entity.
     *
     * @Route("/new", name="apunte_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($fid, $cid, $maid)
    {
        $em = $this->getDoctrine()->getManager();
        $facultad = $em->getRepository('FacultadBundle:Facultad')->find($fid);
        $carrera = $em->getRepository('FacultadBundle:Carrera')->find($cid);
        $materia = $em->getRepository('FacultadBundle:Materia')->find($maid);

        return array(
            'facultad' => $facultad,
            'carrera' => $carrera,
            'materia' => $materia,
            );
    }
    public function ListarAction()
    {
        $em = $this->getDoctrine()->getManager();
        $facultad = $em->getRepository('FacultadBundle:Facultad')->findAll();
        $Form = $this->createForm(new \Sistema\FacultadBundle\form\MostrarFType() , $facultad);
        return $this->render('FotocopiadoraBundle:Apunte:show.html.twig',
        array('facultad'=> $facultad,'form'=> $Form->createView(),));        
        
    }
    public function ListaraAction($fid, $cid, $maid)
    {
       $em = $this->getDoctrine()->getManager(); 
       $apuntes= $em->getRepository('FotocopiadoraBundle:Apunte')->findBy(
               array('facultad_id'=> $fid, 'carrera_id'=> $cid,'materia_id'=> $maid));   
        return $this->render('FotocopiadoraBundle:Apunte:listApuntes.html.twig', array(
                            'apuntes' => $apuntes, ));  //listApuntes prueba
    }
    
    
    
    
    /**
     * Displays a form to edit an existing Apunte entity.
     *
     * @Route("/{id}/edit", name="apunte_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FotocopiadoraBundle:Apunte')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Apunte entity.');
        }

        $editForm = $this->createForm(new ApunteType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Apunte entity.
     *
     * @Route("/{id}", name="apunte_update")
     * @Method("PUT")
     * @Template("FotocopiadoraBundle:Apunte:edit.html.twig")
     */
//    public function updateAction(Request $request, $id)
//    {
//        $em = $this->getDoctrine()->getManager();
//
//        $entity = $em->getRepository('FotocopiadoraBundle:Apunte')->find($id);
//
//        if (!$entity) {
//            throw $this->createNotFoundException('Unable to find Apunte entity.');
//        }
//
//        $deleteForm = $this->createDeleteForm($id);
//        $editForm = $this->createForm(new ApunteType(), $entity);
//        $editForm->bind($request);
//
//        if ($editForm->isValid()) {
//            $em->persist($entity);
//            $em->flush();
//
//            return $this->redirect($this->generateUrl('apunte_edit', array('id' => $id)));
//        }
//
//        return array(
//            'entity'      => $entity,
//            'edit_form'   => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
//        );
//    }
}
