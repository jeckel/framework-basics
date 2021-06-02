<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 02/06/2021
 */

use App\Container\Container;
use App\Controller\IndexController;
use App\Router\Router;

return [
    IndexController::class => static fn() => new IndexController(),
    Router::class => static fn(Container $container) => new Router($container->get('routing_rules'), $container),

    'router' => static fn(Container $container): Router => $container->get(Router::class),

    'routing_rules' => [
        'default' => ['controller' => IndexController::class, 'action' => 'indexAction']
    ]
];
