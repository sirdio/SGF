<?php

namespace Sistema\PedidoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sistema\FacultadBundle\Entity\Facultad;
use Sistema\PedidoBundle\Entity\Pedidocab;
use Sistema\PedidoBundle\Entity\Pedidodet;
//use Sistema\PedidoBundle\Entity\Sumardubtotales;
use Sistema\PedidoBundle\Entity\Estados;
use Sistema\PedidoBundle\Entity\Pagos;
use Sistema\FotocopiadoraBundle\Entity\Apunte;
use Sistema\FotocopiadoraBundle\Entity\Sucursal;
use Sistema\PedidoBundle\form\PedidoType;
use Sistema\UsuariosBundle\Entity\Usuario;
use Sistema\UsuariosBundle\Entity\Alumno;
use Sistema\CuentaBundle\Entity\Movimiento;
use Doctrine\DBAL\Connection;

class DefaultController extends Controller
{
    public function indexAction($usn)
    {
        $em = $this->getDoctrine()->getManager();
        $datosusuario = $em->getRepository('UsuariosBundle:Usuario')->findOneByUsername($usn);
        $tipouser = $datosusuario->getTipou()->getName();
        $trabajo = $em->getRepository('PedidoBundle:Trabajo')->findOneByEmpleado($datosusuario);             
        if(!$trabajo){
            $estado = 0;
            return $this->render('PedidoBundle:Default:index.html.twig', array(
            'tipouser'=>$tipouser, 'estado'=>$estado));
        }
        $pcab =  $trabajo->getPedidocab()->getId(); 
        $estado = 1;
        return $this->render('PedidoBundle:Default:index.html.twig', array(
            'tipouser'=>$tipouser, 'estado'=>$estado, 'pcab'=>$pcab));
    }
 
    public function PedidoInicioAction()
    {
        return $this->render('PedidoBundle:Default:iniciarpedido.html.twig');
    }
    
    public function NuevopAction($usn)
    {
        $saldo = $this->getSaldo($usn);
        $em = $this->getDoctrine()->getManager();
        $facultad = $em->getRepository('FacultadBundle:Facultad')->findAll();
        $form = $this->createForm(new \Sistema\FacultadBundle\form\MostrarFType() , $facultad);
        $id = 4;
        $estado = $em->getRepository('PedidoBundle:Estados')->find($id);
        return $this->render('PedidoBundle:Default:nuevopedido.html.twig', array(
            'estado'=>$estado,
            'facultad'=>$facultad,
            'saldo'=>$saldo,
            'form'   => $form->createView(),
        )); 

    }
   
    public function seleccionarAction($fid, $cid, $maid)
    {     
       $em = $this->getDoctrine()->getManager(); 
       $apuntes= $em->getRepository('FotocopiadoraBundle:Apunte')->findBy(
               array('facultad_id'=> $fid, 'carrera_id'=> $cid,'materia_id'=> $maid));  
        return $this->render('PedidoBundle:Default:listApuntes3.html.twig', array(
                            'apuntes' => $apuntes, ));  //listApuntes prueba   
    }
   
    public function apunterselecAction($id)
    {
        if($id == "0")
        {
            $estapu = 0;
            $subt = 0;
            $lineass[0]=0; 
        }else{
            $estapu = 1;
            $codigos_array = explode('-', $id);
            $n = count($codigos_array);
            $subt = 0;
            $em = $this->getDoctrine()->getManager();
            for ($i = 0; $i < $n; $i++) {             
                $apuntes = $em->getRepository('FotocopiadoraBundle:Apunte')->find($codigos_array[$i]);             
                $lineass[$i+1] = array($i+1 => $apuntes); 
                $j = strlen($apuntes->getPrecio());
                $valorpre = explode('.', $apuntes->getPrecio());
                $subtot = $valorpre[0] + ($valorpre[1]/100);
                $subt = $subt + $subtot;
            }
        }  
       return $this->render('PedidoBundle:Default:datospedido.html.twig', array(
                            'subt'=>$subt,                             
                            'lineas'=>$lineass,
                            'estapu'=>$estapu,
           ));
    }
    
    public function VerificandovaloresAction(Request $request, $precio, $usn)
    {
        $lista=$request->get('lista');
        $saldo = $this->getSaldo($usn);
        $monto = $precio * 0.5;
        $monto = round($monto, 2);
       return $this->render('PedidoBundle:Default:seleccionarformapago.html.twig',
               array( 'precio'=>$precio, 'monto'=>$monto, 'saldo'=>$saldo, 'lista'=>$lista,
       ));        
        
    }
    
    public function SelecSucAction(Request $request)
    {
        $datos=$request->get('lista');
//        echo $datos;
//        die();
        $em = $this->getDoctrine()->getManager(); 
        $sucursal = $em->getRepository('FotocopiadoraBundle:Sucursal')->findAll();
        return $this->render('PedidoBundle:Default:seleccionarsucursal.html.twig',
               array( 'sucursal'=>$sucursal, 'datos'=>$datos,
       ));        
    }            
    //////visto//////
    public function ArmarPedidoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id = 4;
        $estado = $em->getRepository('PedidoBundle:Estados')->find($id);            

        $datos=$request->get('opc1');
        $valores = explode('/', $datos);
        $opcts = $valores[0];//sucursal
        $lista = $valores[1];//apuntes
        $opctp = $valores[2];//tipo de pago
        if($valores[2] == 1){
            $pago = "Pago Parcial 50%";            
        }else{
            $pago = "Pago Total"; 
        }
        $sucursal = $em->getRepository('FotocopiadoraBundle:Sucursal')->find($valores[0]);
        $lineapunte = $valores[1];
        $lineas = explode('-', $lineapunte);
        $n = count($lineas);
        $subt = 0;
        for ($i = 0; $i < $n; $i++) {             
            $apuntes = $em->getRepository('FotocopiadoraBundle:Apunte')->find($lineas[$i]);             
            $registros[$i+1] = array($i+1 => $apuntes); 
            $j = strlen($apuntes->getPrecio());
            $valorpre = explode('.', $apuntes->getPrecio());
            $subtot = $valorpre[0] + ($valorpre[1]/100);
            $subt = $subt + $subtot;
        }        
        return $this->render('PedidoBundle:Default:pedidoarmado.html.twig',
               array( 'id'=>$id,'estado'=>$estado, 'registros'=>$registros,
                      'subt'=>$subt, 'sucursal'=>$sucursal, 'pago'=>$pago,
                      'opctp'=>$opctp, 'opcts'=>$opcts, 'lista'=>$lista,
        ));        
    }
   
    public function CerrarPedidoAction($datos)
    {
        $datospedido = explode(',', $datos);
        $lista = $datospedido[0];
        $opcionpago = $datospedido[1];
        $opcionsucursal = $datospedido[2];
        $estadopedido = $datospedido[3];
        $fechapedido = $datospedido[4];
        $nombreusuario = $datospedido[5];
        $em = $this->getDoctrine()->getManager();
        $datospedet = explode('-', $lista);
        $n = count($datospedet);
        $subt = $this->getObtenerTotal($n, $datospedet);
        $datosusuario = $em->getRepository('UsuariosBundle:Alumno')->findOneByUsername($nombreusuario);   
        //$luusuario = $datosusuario->getnroLU();
        $cuentauser =$datosusuario->getnrocuenta();
        $estados = $this->getObtenerEstado($estadopedido);
        $sucursales = $this->getObtenerSucursal($opcionsucursal);
/////////////////////////////////////////////////////////////////////////////////////////////////
        if($opcionpago == 1){
            $msj = "pago parcial 50%. Pedido N°: ";
            $monto = $subt/2;
            $estpago = 1;
        }  elseif ($opcionpago == 2) {
            $msj = "pago total. Pedido N°: ";
            $monto = $subt;
            $estpago = 0;
        }           
        ///////////////////////////////////////////////////////////////
        ////Registro movimiento de cuenta
        $pedidocab = $this->getGuardarPedidoCab($fechapedido, $subt, $opcionpago, $estpago, $estados, $sucursales, $datosusuario);
        ////cargando detalle del pedido       
        $codigo = $pedidocab->getId();                       
        $estadopeddet = $this->getGuardarPedidoDet($n, $pedidocab, $datospedet);        
        //////////////////////////////////////////////////////////////
        $Saldoactual =($datosusuario->getSaldoactual())- $monto;
        $datosusuario->setSaldoactual($Saldoactual);
        $em->persist($datosusuario);
        $em->flush();         
        $descripcionmov = $msj.$codigo;
        ////Registro movimiento de cuenta
        $estadomovimiento = $this->getGuardarMovimiento($cuentauser, $descripcionmov, $fechapedido, $monto, $Saldoactual); 
        ////Registro pago de pedido
        $estadopago = $this->getGuardarPago( $fechapedido, $descripcionmov, $opcionpago, $monto); 
        if($estadopeddet == true and $estadomovimiento == true and $estadopago == true){
            $mensaje = "El Pedido se Registro con exito.";
            return $this->render('PedidoBundle:Default:msjpedido.html.twig',
                array( 'mensaje'=>$mensaje,
            ));                    
        }else{                                                                  
            $mensaje = "se produjo un erro.";
            return $this->render('PedidoBundle:Default:msjpedido.html.twig',
            array( 'mensaje'=>$mensaje,
            ));            
        }
 
    }            
   
    public function VerPedidosAction($usn)
    {
        $em = $this->getDoctrine()->getManager();
        $datosusuario = $em->getRepository('UsuariosBundle:Alumno')->findOneByUsername($usn); 
//        $nrolu = $datosusuario->getNroLU();
//        $datospedidocab = $em->getRepository('PedidoBundle:PedidoCab')->findByUsuarioid($nrolu);
        $datospedidocab = $em->getRepository('PedidoBundle:PedidoCab')->findByUsuarioalu($datosusuario);
          return $this->render('PedidoBundle:Default:verpedidos.html.twig',
            array( 'datospedidocab'=>$datospedidocab,
            ));                    
    }

    
    public function RegistrarPagoAction($idped)
    {
        $em = $this->getDoctrine()->getManager();
        $datospedidocab = $em->getRepository('PedidoBundle:PedidoCab')->find($idped);
        $nrocuenta = $datospedidocab->getUsuarioalu()->getNrocuenta();
        $datosusuario= $em->getRepository('UsuariosBundle:Alumno')->findOneByNrocuenta($nrocuenta);
        $saldoactual = $datosusuario->getSaldoactual();
        $pedidototal = $datospedidocab->getTotal();
        $tipopagopc =  $datospedidocab->getTipopago();       
        $saldopago = $pedidototal/2;
        $saldopago = round($saldopago, 2);
        $saldoactual = $saldoactual - $saldopago;
        $fecha = date("d-m-Y ");        
        $msjtptm = "pago parcial 50%. Pedido N°: ".$idped;
        ///actualizar pedido
        $estpago = $datospedidocab->getEstadopag();
        if($estpago == 1){
           $estpago = 0;            
        }
        if($datospedidocab->getEstados()->getId() == 1){
            $datoestado = $em->getRepository('PedidoBundle:Estados')->find(3);
            $datospedidocab->setEstados($datoestado);
        }
        $datospedidocab->setEstadopag($estpago);
        $em->persist($datospedidocab);
        $em->flush();        
        ///actualizar saldo actual
        $datosusuario->setSaldoactual($saldoactual);
        $em->persist($datosusuario);
        $em->flush(); 
        ///creo pago
        $estadopago = $this->getGuardarPago( $fecha, $msjtptm, $tipopagopc, $saldopago);
        ///creo movimiento        
        $estadomovimiento = $this->getGuardarMovimiento($nrocuenta, $msjtptm, $fecha, $saldopago, $saldoactual);
        
        if($estadopago == true and $estadomovimiento == true ){
            $mensaje = "El Pago se realizo con exito.";
            return $this->render('PedidoBundle:Default:msj1pedido.html.twig',
                array( 'mensaje'=>$mensaje,
            ));                    
        }else{                                                                  
            $mensaje = "se produjo un erro.";
            return $this->render('PedidoBundle:Default:msj1pedido.html.twig',
            array( 'mensaje'=>$mensaje,
            ));            
        }            
        
    }
    
    //////metodos internos/////////
    public function getSaldo($nus)
    {
        $em = $this->getDoctrine()->getManager(); 
        $datos = $em->getRepository('UsuariosBundle:Alumno')->findOneByUsername($nus);
        $saldo = $datos->getSaldoactual();
        return $saldo;        
    }
    public function getObtenerTotal($n, $datospedet)
    {
        $em = $this->getDoctrine()->getManager(); 
        $subt = 0;
        for ($i = 0; $i < $n; $i++) {             
           $apuntes = $em->getRepository('FotocopiadoraBundle:Apunte')->find($datospedet[$i]);             
           $j = strlen($apuntes->getPrecio());
           $valorpre = explode('.', $apuntes->getPrecio());
           $subtot = $valorpre[0] + ($valorpre[1]/100);
           $subt = $subt + $subtot;
        }    
        return $subt;        
    }   
    public function getGuardarPedidoCab($fechapedido, $subt, $opcionpago, $estpago, $estados, $sucursales, $datosusuario)
    {
        $em = $this->getDoctrine()->getManager(); 
        $pedidocab = new Pedidocab();                
        $pedidocab->setFechap($fechapedido);
        $pedidocab->setUsuarioalu($datosusuario);
        //$pedidocab->setUsuarioid($luusuario);
        //$pedidocab->setEstadoid($estadopedido);//representa el estado de un pedido ejplo iniciado-en proceso-finalizado
        $pedidocab->setEstadopag($estpago);///indica si el pedido se pago completamente...es decir que el unico que puede estar de falto de pago es el estado parcial...
        $pedidocab->setTipopago($opcionpago);///reprecenta el tipo de pago ejemplo pago parcial 50%-pago total
        $pedidocab->setTotal($subt);
        $pedidocab->setEstados($estados); //representa el estado de un pedido ejplo iniciado-en proceso-finalizado       
        //$pedidocab->setSucursalid($opcionsucursal);
        $pedidocab->setSucursal($sucursales);
        $pedidocab->setEntregaest(1);///indica si el pedido esta entregado o no 1 = no entregado y 0 = a entregado
        $em->persist($pedidocab);
        $em->flush();         
        return $pedidocab;        
    }    
    public function getGuardarPedidoDet($n, $pedidocab, $datospedet)
    {
        $em = $this->getDoctrine()->getManager();
        for ($i = 0; $i < $n; $i++) {             
            $pedidodet = new Pedidodet();
            $pedidodet->setPedidocab($pedidocab); 
            $apuntes = $em->getRepository('FotocopiadoraBundle:Apunte')->find($datospedet[$i]);             
            $pedidodet->setApunte($apuntes); 
            $j = strlen($apuntes->getPrecio());
            $valorpre = explode('.', $apuntes->getPrecio());
            $subtot = $valorpre[0] + ($valorpre[1]/100);
            $pedidodet->setSubtotal($subtot);
            $em->persist($pedidodet);
            $em->flush();
        }        
        return true;
    }  
    public function getGuardarMovimiento($cuentauser, $descripcionmov, $fechapedido, $monto, $Saldoactual)
    {
        $em = $this->getDoctrine()->getManager();
        $regmovimiento = new Movimiento();        
        $regmovimiento->setNrocuenta($cuentauser);
        $regmovimiento->setDescripcion($descripcionmov);
        $regmovimiento->setFecha($fechapedido);
        $regmovimiento->setOperacion("Egreso");
        $regmovimiento->setMonto($monto);
        $regmovimiento->setSaldopost($Saldoactual);
        $em->persist($regmovimiento);
        $em->flush();         
        return true;
    }
    public function getGuardarPago( $fechapedido, $descripcionmov, $opcionpago, $monto)
    {
        $em = $this->getDoctrine()->getManager();
        $pago = new Pagos();
        $pago->setFechapago($fechapedido);        
        $pago->setDescripcion($descripcionmov);
        $pago->setEstadopago($opcionpago);
        $pago->setImporte($monto);
        $em->persist($pago);
        $em->flush();
        return true;
    }
    
    public function getObtenerEstado($estadopedido)
    {
        $em = $this->getDoctrine()->getManager();
        $estados = $em->getRepository('PedidoBundle:Estados')->find($estadopedido);
        return $estados;
    }    
    
    public function getObtenerSucursal($opcionsucursal)
    {
        $em = $this->getDoctrine()->getManager();
        $sucursales = $em->getRepository('FotocopiadoraBundle:Sucursal')->find($opcionsucursal);
        return $sucursales;
    }      
   
}
