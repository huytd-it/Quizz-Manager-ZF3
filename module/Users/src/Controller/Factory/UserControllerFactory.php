<?php
namespace Users\Controller\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Users\Controller\UserController;
use Users\Service\UserManager;


class UserControllerFactory implements FactoryInterface{

    public function __invoke(ContainerInterface $container,$requestedName,array $options=null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $userManager = $container->get(UserManager::class);
        return new UserController($entityManager,$userManager);
    }
}