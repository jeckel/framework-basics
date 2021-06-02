<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 02/06/2021
 */

declare(strict_types=1);

namespace App;

use App\Container\Container;
use App\Router\Router;

class Kernel
{
    private Container $container;

    public function __construct()
    {
        /** @var array $containerConfig */
        $containerConfig = include dirname(__DIR__) . '/config/container.php';
        $this->container = new Container($containerConfig);
    }

    public function bootstrap(): string
    {
        /** @var Router $router */
        $router = $this->container->get('router');

        $callable = $router->getHandler((string) $_SERVER['REQUEST_URI']);

//        var_dump($callable);

        $response = (string) call_user_func($callable);

        return $response;
    }
}
