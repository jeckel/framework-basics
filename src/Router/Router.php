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
     * @param Request $request
     * @return callable
     */
    public function getHandler(Request $request): callable
    {
        $route = $this->findMatchingRoute($request);
        if (null === $route) {
            return $this->resolve(
                new MatchedRoute(
                    $this->routingRules['default']['controller'],
                    $this->routingRules['default']['action'],
                    []
                )
            );
        }

        return $this->resolve($route);
    }

    /**
     * @param Request $request
     * @return MatchedRoute|null
     */
    protected function findMatchingRoute(Request $request): ?MatchedRoute
    {
        $matches = [];
        /**
         * @var string $rule
         * @var array{controller: class-string, action: string} $handler
         */
        foreach ($this->routingRules['routes'] as $rule => $handler) {
            $reg = '/(\{\w*\})/m';
            $subst = '(\\\\w*)';
            $eregRule = '/^' . str_replace('/', '\/', preg_replace($reg, $subst, $rule)) . '$/';

            if (preg_match_all($eregRule, $request->getRequestUri(), $matches)) {
                array_shift($matches);
                $values = array_map(static fn (array $match) => $match[0], $matches);
                preg_match_all('/\{(\w*)\}/m', $rule, $matches);
                $varNames = $matches[1];

                return new MatchedRoute($handler['controller'], $handler['action'], array_combine($varNames, $values));
            }
        }
        return null;
    }

    /**
     * @param MatchedRoute $matchedRoute
     * @return callable
     */
    protected function resolve(MatchedRoute $matchedRoute): callable
    {
        /** @psalm-suppress MixedInferredReturnType */
        return fn(): array =>
            /** @psalm-suppress MixedReturnStatement */
            call_user_func_array(
                [
                    $this->container->get($matchedRoute->getControllerName()),
                    $matchedRoute->getActionName(),
                ],
                $matchedRoute->getArguments()
            );
    }
}
