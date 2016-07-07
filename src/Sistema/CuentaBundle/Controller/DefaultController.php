<?php

namespace Sistema\CuentaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sistema\UsuariosBundle\Entity\Empleado;
use Sistema\UsuariosBundle\Entity\EmpleadoRepository;
use Sistema\CuentaBundle\Entity\Movimiento;
use Sistema\CuentaBundle\Entity\MovimientoRepository;
use Sistema\CuentaBundle\form\MovimientoType;
use Sistema\UsuariosBundle\Entity\Alumno;
use Sistema\UsuariosBundle\Entity\AlumnoRepository;
use Sistema\PedidoBundle\Entity\Pagos;
use Sistema\PedidoBundle\Entity\Pedidocab;
class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CuentaBundle:Default:index.html.twig');
    }

    public function ConsultarSaldoAction($tipou)
    {
        $em = $this->getDoctrine()->getManager();
        $datosusuario= $em->getRepository('UsuariosBundle:Alumno')->findOneByUsername($tipou);
        return $this->render('CuentaBundle:Movimiento:datossaldo.html.twig',Array('datosusuario'=>$datosusuario));
    }    
    
    public function ConsultarUltMovAction($tipou)
    {
        $em = $this->getDoctrine()->getManager();
        $datosusuario= $em->getRepository('UsuariosBundle:Alumno')->findOneByUsername($tipou);
        $nrocta = $datosusuario->getNrocuenta();
        
        $datosmovimientos = $em->getRepository('CuentaBundle:Movimiento')->findByNrocuenta($nrocta);
        $cantidad = count($datosmovimientos);        
        $porpagina=5;        
        $totalPaginas=ceil($cantidad/$porpagina);
        if ($totalPaginas > 1)
        {
            $sobrante = $cantidad - $porpagina;
            $offset = $sobrante;            
        }else{
            $offset = 1;
        }    
        if($cantidad == 0)
        {
            return $this->render('CuentaBundle:Movimiento:datosultimosmov.html.twig',Array('cantidad'=>$cantidad));            
         }elseif($cantidad < 6)
         {
            $em1=$this->getDoctrine()
                        ->getManager()
                        ->createQueryBuilder('CuentaBundle:Movimiento')
                        ->select('m')
                        ->from('CuentaBundle:Movimiento','m')
                        ->where('m.nrocuenta = :nrocta')
                        ->orderBy("m.id","asc")
                        ->setParameter('nrocta', $nrocta)                  
                        ->getQuery();
            $datos=$em1->getArrayResult();                
         }else{
            $em1=$this->getDoctrine()
                        ->getManager()
                        ->createQueryBuilder('CuentaBundle:Movimiento')
                        ->select('m')
                        ->from('CuentaBundle:Movimiento','m')
                        ->where('m.nrocuenta = :nrocta')
                        ->orderBy("m.id","asc")
                        ->setParameter('nrocta', $nrocta)                  
                        ->setFirstResult($offset)
                        ->setMaxResults($porpagina)
                        ->getQuery();
            $datos=$em1->getArrayResult();              
        }   
        return $this->render('CuentaBundle:Movimiento:datosultimosmov.html.twig',Array('datos'=>$datos,'cantidad'=>$cantidad));
        
    }     
    
    public function AcreditarSaldoAction()
    {
        return $this->render('CuentaBundle:Movimiento:consultarcuenta.html.twig');
    }

    public function BuscarCtaAction($id)
    {
        $nrocuenta = $id;        
        $em = $this->getDoctrine()->getManager();
        $datoscta = $em->getRepository('UsuariosBundle:Alumno')->findOneByNrocuenta($nrocuenta);
        if(!$datoscta){
            $msaj = "El número de cuenta igresado no existe.";
            return $this->render('CuentaBundle:Movimiento:msjconsulta.html.twig',
                    array('msaj' => $msaj));
        }
        $movimiento = new Movimiento();
        $movimiento->setNrocuenta($datoscta->getNrocuenta());
        $fechaop = date("d-m-Y");
        $movimiento->setFecha($fechaop);
        $movimiento->setDescripcion("Ingreso de dinero en cuenta.");
        $movimiento->setOperacion("Ingreso");
        if($datoscta->getSaldoactual()== null){
            $datoscta->setSaldoactual(0,00);
        }
        return $this->render('CuentaBundle:Movimiento:datoscuenta.html.twig',
                    array('datoscta' => $datoscta,
                            'nrocuenta' => $nrocuenta,
                            'fechaop' => $fechaop,
                          'movimiento' => $movimiento,
                          ));
    }    
    public function AgregarAction(Request $request)
    {
        if ($request->isMethod('POST')) {
            foreach($_POST as $nombre => $valor){
                $nrocta = $nombre;
                $importe = $valor;
            }             
            if (is_numeric($nrocta)){
                if (is_numeric($importe) && $importe > 0){
                    $em = $this->getDoctrine()->getManager();
                    $datoscta = $em->getRepository('UsuariosBundle:Alumno')->findOneByNroLU($nrocta);                    
                    $salact = $importe + $datoscta->getSaldoactual();
                    $datoscta->setSaldoactual($salact);
                    $em->flush();
                    $movimiento = new Movimiento();
                    $pago = new Pagos();
                    $movimiento->setNrocuenta($datoscta->getNrocuenta());
                    $fechaop = date("d-m-Y");
                    $movimiento->setFecha($fechaop);
                    $movimiento->setDescripcion("Ingreso de dinero en cuenta.");
                    $movimiento->setOperacion("Ingreso");
                    $movimiento->setMonto($importe);
                    $movimiento->setSaldopost($salact);                    
                    $em1 = $this->getDoctrine()->getManager();
                    $em1->persist($movimiento);
                    $em1->flush();
                    $estado = 1;             
                    
                    $pago->setFechapago($fechaop);
                    $pago->setDescripcion("Pago en concepto de ingreso de efectivo:");
                    $pago->setImporte($importe);
                    $pago->setEstadopago(0);
                    $em1->persist($pago);
                    $em1->flush();
                    $msaj = "El importe fue ingresado correctamente.";
                    return $this->render('CuentaBundle:Movimiento:msjconsulta2.html.twig',
                    array('msaj' => $msaj,
                            'estado' => $estado,
                            'datoscta' => $datoscta,
                            'movimiento' => $movimiento,
                        )); 
                }else{
                    $estado = 2;
                    $msaj = "El importe ingresado debe ser positivo.";
                    return $this->render('CuentaBundle:Movimiento:msjconsulta2.html.twig',
                    array('msaj' => $msaj,
                        'estado' => $estado,
                        ));                
                }
            }else{
            $msaj = "Se produjo un error en la carga del importe, intente nuevamente.";
            return $this->render('CuentaBundle:Movimiento:msjconsulta2.html.twig',
                    array('msaj' => $msaj,
                        'estado' => $estado,
                        ));                
            }
        }
        $msaj = "Se produjo un error en la carga del importe, intente nuevamentessss.";
        return $this->render('CuentaBundle:Movimiento:msjconsulta.html.twig',
                    array('msaj' => $msaj));
    }
    public function DetalleSaldoAction($usn)
    {
        $em = $this->getDoctrine()->getManager();
        $usuario = $em->getRepository('UsuariosBundle:Alumno')->findOneByUsername($usn); 
        $saldoactual = $usuario->getSaldoactual();
        $cuenta= $usuario->getNrocuenta();                
        $pedidoadeudado = $em->getRepository('PedidoBundle:Pedidocab')->findByPedido($cuenta);
        return $this->render('CuentaBundle:Movimiento:detallesaldo.html.twig',
                    array('pedidoadeudado' => $pedidoadeudado, 'saldoactual' => $saldoactual));

    }
    public function DetalleMovCtaAction(Request $request, $usn)
    {
       $em1 = $this->getDoctrine()->getManager();
       $usuario = $em1->getRepository('UsuariosBundle:Alumno')->findOneByUsername($usn);  
       $nrocuenta = $usuario->getNrocuenta();
       $total_count=$this->getTotalMovimiento($nrocuenta);
        $page=$request->get('page');
        $porpagina=10;        
        $totalPaginas=ceil($total_count/$porpagina);
        if(!is_numeric($page))
        {
            $page=1;
        }else{
             $page=floor($page);
        }        
        if($total_count<=$porpagina)
        {
            $page=1;
        } 
        if(($page*$porpagina)>$total_count)
        {
            $page=$totalPaginas;
        }
        $offset=0;
        if($page>1)
        {
            $offset=$porpagina*($page-1);
        }        
        $em=$this->getDoctrine()
                        ->getManager()
                        ->createQueryBuilder('CuentaBundle:Movimiento')
                        ->select('m')
                        ->from('CuentaBundle:Movimiento','m')
                ->WHERE('m.nrocuenta = :nrocuenta')
                        //->orderBy("m.fecha","asc")
                        ->setParameter('nrocuenta', $nrocuenta)
                        ->setFirstResult($offset)
                        ->setMaxResults($porpagina)
                        ->getQuery();
        $datos=$em->getArrayResult();
        if (!$datos) {
            $mensaje = "No existen movimientos realizado sobre esta cuenta.";
            return $this->render('CuentaBundle:Movimiento:msjpedido.html.twig',
                    array('mensaje' => $mensaje));
        }
        return $this->render('CuentaBundle:Movimiento:detallemovimiento.html.twig',compact("datos","porpagina","totalPaginas","total_count","page"));
    }
    
    public function getTotalMovimiento($nrocuenta)
    {        
        $em = $this->getDoctrine()->getManager();
        $movimientos = $em->getRepository('CuentaBundle:Movimiento')->findByNrocuenta($nrocuenta);
        $datos = count($movimientos);
        return $datos;
    }
    
    public function VerDetalleMovAction(Request $request, $pid)
    {
        $page=$request->get('page');
        $em = $this->getDoctrine()->getManager();
        $movimiento = $em->getRepository('CuentaBundle:Movimiento')->find($pid);
        return $this->render('CuentaBundle:Movimiento:detmov.html.twig',
                    array('movimiento' => $movimiento, 'page'=>$page));        
    }
    
}
