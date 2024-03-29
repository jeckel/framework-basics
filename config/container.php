<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 02/06/2021
 */

use App\Container\Container;
use App\Controller\IndexController;
use App\Renderer\Renderer;
use App\Router\Router;

return [
    IndexController::class => static fn() => new IndexController(),
    Router::class => static fn(Container $container) => new Router($container->get('routing_rules'), $container),
    Renderer::class => static fn() => new Renderer(
        dirname(__DIR__) . '/src/templates',
        'layout.phtml'
    ),

    'router' => static fn(Container $container): Router => $container->get(Router::class),
    'renderer' => static fn(Container $container): Renderer => $container->get(Renderer::class),

    'routing_rules' => [
        'default' => [
            'controller' => IndexController::class,
            'action' => 'indexAction'
        ],
        'routes' => [
            "/hello/{lastname}/{firstname}" => [
                'controller' => IndexController::class,
                'action' => 'helloAction'
            ],
            "/hello/{lastname}" => [
                'controller' => IndexController::class,
                'action' => 'helloAction'
            ],
        ]
    ]
];
