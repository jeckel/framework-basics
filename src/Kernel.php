<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 02/06/2021
 */

declare(strict_types=1);

namespace App;

use App\Container\Container;
use App\Renderer\Renderer;
use App\Router\Request;
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

        /** @var Renderer $renderer */
        $renderer = $this->container->get('renderer');

        /** @psalm-suppress MixedArgumentTypeCoercion */
        $callable = $router->getHandler(new Request($_SERVER));

        /** @var array{view: string, args: array} $response */
        $response = call_user_func($callable);

        return $renderer->render($response['view'], $response['args']);
    }
}
