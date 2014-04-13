<?php

/*
 * This file is part of the BetsolRoutesExportBundle package.
 *
 * (c) Slava Fomin II <http://www.betsol.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Betsol\RoutesExportBundle\Twig;

use Betsol\RoutesExportBundle\Routing\RoutesExporter;

/**
 * Class RoutesExporterExtension
 * @package Betsol\RoutesExportBundle\Twig
 */
class RoutesExporterExtension extends \Twig_Extension
{
    /** @var  RoutesExporter */
    protected $routesExporter;

    /**
     * @param RoutesExporter $routesExporter
     */
    public function __construct(RoutesExporter $routesExporter)
    {
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'routes_exporter';
    }

    /**
     * @inheritdoc
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('export_routes', [$this, 'exportRoutesFunction']),
        ];
    }

    /**
     * @return array
     */
    public function exportRoutesFunction()
    {
        return [
            [
                'name' => 'hello.world',
                'path' => '/hello/{world}'
            ]
        ];
    }
}