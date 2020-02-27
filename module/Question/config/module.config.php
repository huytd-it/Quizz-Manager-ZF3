<?php
namespace Question;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'question' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/question[/:action][/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        
                    ],
                    'defaults' => [
                        'controller' => Controller\QuestionController::class,
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        // 'factories' => [
        //    Controller\QuestionController::class => InvokableFactory::class,
        // ],
    ],
    'view_manager' =>[
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
 
];
