<?php 
namespace Sistema\UsuariosBundle\listener;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Routing\Router;

class LoginListener 
{
    private $contexto, $router, $username;
    public function __construct(SecurityContext $context, Router $router)
    {
        $this->contexto = $context;
        $this->router = $router;
        
    }
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $token = $event->getAuthenticationToken();
        $this->username = $token->getUser()->getRoles();
    }
    public function onKernelResponse(FilterResponseEvent $event)
    {
       if (null != $this->username){
            if ($this->contexto->isGranted('ROLE_ALUMNO')) {
                $portada = $this->router->generate('pagina_alumno');//, array('usuario' => $this->username ));
            } elseif ($this->contexto->isGranted('ROLE_PROF')){
                $portada = $this->router->generate('pagina_profe');//, array('usuario' => $this->username ));
            } elseif ($this->contexto->isGranted('ROLE_EMP')){
                $portada = $this->router->generate('pagina_emp');//, array('usuario' => $this->username ));
            }elseif ($this->contexto->isGranted('ROLE_ADMIN')){
                $portada = $this->router->generate('pagina_adm');//, array('usuario' => $this->username ));
            } 
            $event->setResponse(new RedirectResponse($portada));
            
        } 
    } 
}

?>