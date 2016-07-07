<?php

namespace Sistema\PedidoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\DBAL\Connection;
use Sistema\FacultadBundle\Entity\Facultad;
use Sistema\PedidoBundle\Entity\Pedidocab;
use Sistema\PedidoBundle\Entity\Pedidodet;
use Sistema\PedidoBundle\Entity\Estados;
use Sistema\PedidoBundle\Entity\Pagos;
use Sistema\PedidoBundle\Entity\Trabajo;
//use Sistema\FotocopiadoraBundle\Entity\Apunte;
//use Sistema\FotocopiadoraBundle\Entity\Sucursal;
//use Sistema\PedidoBundle\form\PedidoType;
//use Sistema\UsuariosBundle\Entity\Usuario;
//use Sistema\UsuariosBundle\Entity\Alumno;
//use Sistema\CuentaBundle\Entity\Movimiento;


class PedidoController extends Controller
{
    public function ListarTrabajosAction($usn)
    {
        $em = $this->getDoctrine()->getManager();
        $datosusuario = $em->getRepository('UsuariosBundle:Empleado')->findOneByUsername($usn);
        $codsuc = $datosusuario->getSucid();
        $datossucursal = $em->getRepository('FotocopiadoraBundle:Sucursal')->find($codsuc);
        $datosestado = $em->getRepository('PedidoBundle:Estados')->find(4);
        $datospedcab = $em->getRepository('PedidoBundle:Pedidocab')->findBy(
                array( 'sucursal'  => $datossucursal, 'estados' => $datosestado));
        
        
        $trabajo = $em->getRepository('PedidoBundle:Trabajo')->findOneByEmpleado($datosusuario);
        if(!$trabajo){
            $estado = 0;
            return $this->render('PedidoBundle:Pedido:listadetrabajos.html.twig',
                array('datospedcab'=>$datospedcab, 'estado'=>$estado));
        }
        $pcab =  $trabajo->getPedidocab()->getId();
        $estado = 1;
        return $this->render('PedidoBundle:Pedido:listadetrabajos.html.twig',
                array('estado'=>$estado, 'pcab'=>$pcab));

    }

    public function AtenderPedidoAction($usn, $pcab)
    {
        $em = $this->getDoctrine()->getManager();
        $datosusuario = $em->getRepository('UsuariosBundle:Empleado')->findOneByUsername($usn);
        $pedidocab = $em->getRepository('PedidoBundle:Pedidocab')->find($pcab);
        $pedidodet = $pedidocab->getPedidodet();
       
        if(!$pedidocab and !$pedidodet){
            $mensaje = "Se Produjo un erro al consultar los pedidos consulte con el administrador.";
            return $this->render('PedidoBundle:Pedido:msjtrabajos.html.twig',
                array('mensaje'=>$mensaje));
        }
        $i =1;
        foreach($pedidodet as $pdet){
            $registros[$i] = array( "id" =>$pdet->getId(),"nombre" => $pdet->getApunte()->getNombre(),
                "cant" =>$pdet->getApunte()->getNropag(), "precio" =>$pdet->getSubtotal(),
                "direc" =>$pdet->getApunte()->getPath(), "codapu"=>$pdet->getApunte()->getId());           
            $i++;
        }
        $datostrabajo = $em->getRepository('PedidoBundle:Trabajo')->findOneByPedidocab($pedidocab);
        if(!$datostrabajo){
            $trabajo = new Trabajo();
            $trabajo->setEmpleado($datosusuario);
            $trabajo->setPedidocab($pedidocab);
            $em->persist($trabajo);
            $em->flush(); 
        }
        $estado = $em->getRepository('PedidoBundle:Estados')->find(2);
        $pedidocab->setEstados($estado);
        $em->persist($pedidocab);        
        $em->flush(); 
        return $this->render('PedidoBundle:Pedido:pedidoenproceso.html.twig',
                array('pedidocab'=>$pedidocab,'registros'=>$registros));        
    }
    
    
    public function BuscarArcdesAction($fId)
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
    
    public function CerrarTrabajoAction($pedid, $usn)
    {
        $em = $this->getDoctrine()->getManager();
        $datosusuario = $em->getRepository('UsuariosBundle:Usuario')->findByUsername($usn);
        $datostrabajo = $em->getRepository('PedidoBundle:Trabajo')->findOneByEmpleado($datosusuario);
        $datospedidocab = $em->getRepository('PedidoBundle:Pedidocab')->find($pedid);
        if (count($datostrabajo)== 1 and count($datospedidocab)== 1){
            if ($datospedidocab->getEstadopag()== 1){
                $datoestado = $em->getRepository('PedidoBundle:Estados')->find(1);
            }else{                
                $datoestado = $em->getRepository('PedidoBundle:Estados')->find(3);
            }
            $datospedidocab->setEstados($datoestado);                     
            $em->persist($datospedidocab);        
            $em->flush();
            $em->remove($datostrabajo);    
            $em->flush();
            $mensaje = "Pedido Cerrado";
            return $this->render('PedidoBundle:Pedido:msjtrabajos.html.twig',
                array('mensaje'=>$mensaje));     
        }
        $mensaje = "Se Produjo un error al cerrar el pedido intente de nuevo. En caso de 
            de continuar con el error comunicar al administrador.";
        return $this->render('PedidoBundle:Pedido:msjtrabajos.html.twig',
                array('mensaje'=>$mensaje));
        
    }
    public function MostrarPFAction($usn)
    {
        $em = $this->getDoctrine()->getManager();
        $datosusuario = $em->getRepository('UsuariosBundle:Empleado')->findOneByUsername($usn);
        $codsuc = $datosusuario->getSucid();
        $datossucursal = $em->getRepository('FotocopiadoraBundle:Sucursal')->find($codsuc);
        $datoestado = $em->getRepository('PedidoBundle:Estados')->find(3);
        $datospedidocab = $em->getRepository('PedidoBundle:Pedidocab')->findBy(
                array( 'sucursal'  => $datossucursal, 'estados' => $datoestado, 'entregaest'=> 1 ));
        if(!$datospedidocab){
            $mensaje = "No existen pedidos finalizados";
            return $this->render('PedidoBundle:Pedido:msjtrabajos.html.twig',
                array('mensaje'=>$mensaje));
        }     
        return $this->render('PedidoBundle:Pedido:mostrarpedidosfinalizados.html.twig', array('pedidocab'=>$datospedidocab));        
    }
    
    public function EntregarPedidoAction($idped)
    {
        $em = $this->getDoctrine()->getManager();
        $datospedidocab = $em->getRepository('PedidoBundle:Pedidocab')->find($idped);
        $datospedidocab->setEntregaest(0);
        $em->persist($datospedidocab);
        $em->flush();
        $mensaje = "La entrega fue registrada con exito.";
        return $this->render('PedidoBundle:Pedido:msjentrega.html.twig',
                array('mensaje'=>$mensaje));
    }
    
}


?>
