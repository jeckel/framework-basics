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
        $route = $this->findMatchingRoute($requestUri);
        if (null === $route) {
            return $this->resolve($this->routingRules['default']);
        }

        return $this->resolve($route['handler'], $route['matches']);
    }

    /**
     * @param string $requestUri
     * @return array|null
     */
    protected function findMatchingRoute(string $requestUri): ?array
    {
        $matches = [];
        /**
         * @var string $rule
         * @var array $handler
         */
        foreach ($this->routingRules['routes'] as $rule => $handler) {
            if (preg_match($rule, $requestUri, $matches)) {
                return [
                    'handler' => $handler,
                    'matches' => [$matches[1]],
                ];
            }
        }
        return null;
    }

    /**
     * @param array{controller: class-string, action: string} $rule
     * @param array|null $arguments
     * @return callable
     */
    protected function resolve(array $rule, ?array $arguments = null): callable
    {
        if (null === $arguments) {
            return [
                $this->container->get($rule['controller']),
                $rule['action'],
            ];
        }

        return fn(): callable => call_user_func_array(
            [
                $this->container->get($rule['controller']),
                $rule['action'],
            ],
            $arguments
        );
    }
}
