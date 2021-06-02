<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 02/06/2021
 */

declare(strict_types=1);

namespace App\Router;

/**
 * Class Request
 * @package App\Router
 */
class Request
{
    protected string $requestUri;
    protected string $method;

    /**
     * Request constructor.
     * @param array{REQUEST_URI: string, REQUEST_METHOD: string} $server
     */
    public function __construct(array $server)
    {
        $this->requestUri = $server['REQUEST_URI'];
        $this->method = $server['REQUEST_METHOD'];
    }

    /**
     * @return string
     */
    public function getRequestUri(): string
    {
        return $this->requestUri;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }
}
