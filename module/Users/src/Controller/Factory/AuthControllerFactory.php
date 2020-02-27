<?php 
namespace Users\Controller\Factory;

use Interop\Container\ContainerInterface;
use Laminas\Authentication\AuthenticationService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Users\Controller\AuthController;
use Users\Service\AuthManager;
use Users\Service\UserManager;

class AuthControllerFactory implements FactoryInterface {
    
    public function __invoke(ContainerInterface $container,$requestedName,array $options=null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $userManager = $container->get(UserManager::class);
        $authManager = $container->get(AuthManager::class);
        $authService = $container->get(AuthenticationService::class);

        return new AuthController($entityManager,$userManager,$authManager,$authService);
    }

}
?>