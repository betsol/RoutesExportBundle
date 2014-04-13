<?php

/*
 * This file is part of the BetsolRoutesExportBundle package.
 *
 * (c) Slava Fomin II <http://www.betsol.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Betsol\RoutesExportBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class BetsolRoutesExportExtension extends Extension
{
    /**
     * @inheritdoc
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = $this->processConfiguration(new Configuration(), $configs);
        $container->setParameter('betsol.routes_export.config', $config);
        $loader = new YamlFileLoader($container, new FileLocator(
            __DIR__ . '/../Resources/config'
        ));
        $loader->load('config.yml');
    }
}