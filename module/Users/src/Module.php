<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Users;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Mvc\MvcEvent;
use Users\Controller\AuthController;
use Users\Service\AuthManager;


class Module
{
    const VERSION = '3.1.3';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    public function getAutoloaderConfig()
    {
        return [
           'Laminas\Loader\StandardAutoloader' => [
               'namespace' => [
                   __NAMESPACE__=>__DIR__.'/src/'.__NAMESPACE__
               ],
            ],
        ];
    }
    public function onBootstrap(MvcEvent $event)
    {
        $eventManager = $event->getApplication()->getEventManager();
        $shareEventManager =  $eventManager->getSharedManager();
        $shareEventManager->attach(AbstractActionController::class, MvcEvent::EVENT_DISPATCH,[$this,'onDispatch'],100);

    }
    public function onDispatch(MvcEvent $event)
    {
       $controllerName = $event->getRouteMatch()->getParam('controller',null);
       $actionName = $event->getRouteMatch()->getParam('action',null);
       $authManager = $event->getApplication()->getServiceManager()->get(AuthManager::class);

       if(!$authManager->filterAccess($controllerName,$actionName)&& $controllerName != AuthController::class){
           $controller  = $event->getTarget();
           return $controller->redirect()->toRoute('login');    
       }
    }
}
