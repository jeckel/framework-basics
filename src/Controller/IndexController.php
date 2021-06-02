<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 02/06/2021
 */

declare(strict_types=1);

namespace App\Controller;

class IndexController
{
    public function indexAction(): array
    {
        return ['view' => 'index.phtml', 'args' => ['title' => 'Hello World']];
    }

    public function helloAction(string $name): array
    {
        return ['view' => 'index.phtml', 'args' => ['title' => 'Hello ' . $name]];
    }
}
