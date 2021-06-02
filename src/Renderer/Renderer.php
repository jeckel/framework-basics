<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 02/06/2021
 */

declare(strict_types=1);

namespace App\Renderer;

/**
 * Class Renderer
 * @package App\Renderer
 */
class Renderer
{
    protected string $templatePath;
    protected string $defaultLayout;
    protected array $defaults = [
        'title' => 'Undefined title'
    ];

    /**
     * Renderer constructor.
     * @param string $templatePath
     * @param string $defaultLayout
     */
    public function __construct(string $templatePath, string $defaultLayout)
    {
        $this->templatePath = $templatePath;
        $this->defaultLayout = $defaultLayout;
    }

    /**
     * @param string $view
     * @param array  $args
     * @return string
     */
    public function render(string $view, array $args = []): string
    {
        if (isset($args['this'])) {
            throw new SecurityException('F**k!');
        }

        $values = array_merge($this->defaults, $args);

        $viewPath = $this->templatePath . DIRECTORY_SEPARATOR . $view;

        if (! is_readable($viewPath)) {
            throw new TemplateNotFoundException('Impossible to read template: ' . $viewPath);
        }

        ob_start();
        extract($values);
        /** @psalm-suppress UnresolvableInclude */
        include $this->templatePath . DIRECTORY_SEPARATOR . $this->defaultLayout;

        return ob_get_clean();
    }
}
