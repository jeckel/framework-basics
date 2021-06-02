<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 02/06/2021
 */

declare(strict_types=1);

namespace App\Router;

use App\Container\Container;

/**
 * Class Router
 * @package App\Router
 */
class Router
{
    /**
     * @var array{controller: class-string, action: string}[]
     */
    protected array $routingRules;
    protected Container $container;

    /**
     * Router constructor.
     * @param array{controller: class-string, action: string}[] $routingRules
     * @param Container $container
     */
    public function __construct(array $routingRules, Container $container)
    {
        $this->routingRules = $routingRules;
        $this->container = $container;
    }

    /**
     * @param string $requestUri
     * @return callable
     */
    public function getHandler(string $requestUri): callable
    {
        return $this->resolve($this->routingRules[$requestUri] ?? $this->routingRules['default']);
    }

    /**
     * @param array{controller: class-string, action: string} $rule
     * @return callable
     */
    protected function resolve(array $rule): callable
    {
        return [
            $this->container->get($rule['controller']),
            $rule['action']
        ];
    }
}
