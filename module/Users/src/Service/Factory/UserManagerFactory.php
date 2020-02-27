<?php
namespace Users\Service\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Users\Service\UserManager;

class UserManagerFactory implements FactoryInterface{

    public function __invoke(ContainerInterface $container,$requestedName,array $options=null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        return new UserManager($entityManager);
    }
}