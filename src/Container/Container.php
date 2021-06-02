<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 02/06/2021
 */

declare(strict_types=1);

namespace App\Container;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class Container
 * @package App\Container
 */
class Container implements ContainerInterface
{
    private array $container;

    /**
     * Container constructor.
     * @param array $container
     */
    public function __construct(array $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $id
     * @return mixed
     * @throws NotFoundException
     */
    public function get(string $id): mixed
    {
        if (! isset($this->container[$id])) {
            throw new NotFoundException('Nothing defined for ' . $id);
        }

        if (is_callable($this->container[$id])) {
            $this->container[$id] = $this->container[$id]($this);
        }

        return $this->container[$id];
    }

    /**
     * @param string $id
     * @return bool
     */
    public function has(string $id): bool
    {
        return isset($this->container[$id]);
    }
}
