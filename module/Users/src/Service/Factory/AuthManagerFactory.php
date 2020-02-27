<?php 
namespace Users\Service\Factory;

use Interop\Container\ContainerInterface;
use Laminas\Authentication\AuthenticationService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Session\SessionManager;
use Users\Service\AuthManager;

class AuthManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container,$requestedName,array $options=null)
    {
        $authencationService = $container->get(AuthenticationService::class);
        $sessionManager = $container->get(SessionManager::class);
      
        return new AuthManager($authencationService,$sessionManager);
    }
}