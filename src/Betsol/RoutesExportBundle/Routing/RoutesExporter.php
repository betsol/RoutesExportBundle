<?php

/*
 * This file is part of the BetsolRoutesExportBundle package.
 *
 * (c) Slava Fomin II <http://www.betsol.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Betsol\RoutesExportBundle\Routing;

use Symfony\Component\Routing\RouterInterface;

/**
 * Class RoutesExporter
 * @package Betsol\RoutesExportBundle\Routing
 */
class RoutesExporter
{
    /** @var RouterInterface */
    protected $router;

    /**
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @param string $pattern
     * @return array
     */
    public function getRoutes($pattern = '')
    {
        $routes = [];

        foreach($this->router->getRouteCollection()->all() as $routeName => $route) {

            if ($pattern && !preg_match($pattern, $routeName)) {
                continue;
            }

            $routes[] = [
                'name' => $routeName,
                'path' => $route->getPath(),
            ];
        }

        return $routes;
    }
}