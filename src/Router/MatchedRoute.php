<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 02/06/2021
 */

declare(strict_types=1);

namespace App\Router;

class MatchedRoute
{
    protected string $controllerName;
    protected string $actionName;
    protected array $arguments = [];

    /**
     * MatchedRoute constructor.
     * @param string $controllerName
     * @param string $actionName
     * @param array  $arguments
     */
    public function __construct(string $controllerName, string $actionName, array $arguments)
    {
        $this->controllerName = $controllerName;
        $this->actionName = $actionName;
        $this->arguments = $arguments;
    }

    /**
     * @return string
     */
    public function getControllerName(): string
    {
        return $this->controllerName;
    }

    /**
     * @return string
     */
    public function getActionName(): string
    {
        return $this->actionName;
    }

    /**
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }
}
