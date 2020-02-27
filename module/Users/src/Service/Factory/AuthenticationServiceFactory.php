<?php 
namespace Users\Service\Factory;

use Interop\Container\ContainerInterface;
use Laminas\Authentication\AuthenticationService;
use Laminas\Authentication\Storage\Session;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Session\SessionManager;
use Users\Service\AuthAdapter;

class AuthenticationServiceFactory implements FactoryInterface{
    
    public function __invoke(ContainerInterface $container,$requestedName,array $options=null)
    {
        $authAdapter = $container->get(AuthAdapter::class);
        $sessionManager = $container->get(SessionManager::class);
        $authStorge = new Session('Laminas_Auth','session',$sessionManager);
        return new AuthenticationService($authStorge,$authAdapter,$sessionManager);
    }
}