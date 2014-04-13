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

    /** @var  array */
    protected $config;

    /**
     * @param RouterInterface $router
     * @param array $config
     */
    public function __construct(RouterInterface $router, array $config)
    {
        $this->router = $router;
        $this->config = $config;
    }

    /**
     * @param string $presetName
     * @return array
     */
    public function getRoutes($presetName = 'default')
    {
        $routes = [];

        $includePatterns = [];
        $excludePatterns = [];

        $preset = $this->getPresetFromConfig($presetName);
        if ($preset) {
            $includePatterns = $this->getPatternsFromPreset($preset, 'include');
            $excludePatterns = $this->getPatternsFromPreset($preset, 'exclude');
        }

        $usePatterns = true;
        if ('default' == $presetName && !isset($this->config['presets']['default'])) {
            $usePatterns = false;
        }

        foreach($this->router->getRouteCollection()->all() as $routeName => $route) {
            $includeRoute = true;
            $matches = [];
            if ($usePatterns) {
                $includeRoute =
                    $this->isPatternsApplyToRouteName($includePatterns, $routeName, $matches) &&
                    !$this->isPatternsApplyToRouteName($excludePatterns, $routeName)
                ;
            }

            if ($includeRoute) {
                $routes[] = [
                    'name' => (isset($matches[1]) ? $matches[1] : $routeName),
                    'path' => $route->getPath(),
                ];
            }
        }

        return $routes;
    }

    /**
     * @param string $presetName
     * @return array|null
     * @throws \RuntimeException
     */
    protected function getPresetFromConfig($presetName = 'default')
    {
        if (isset($this->config['presets'][$presetName])) {
            return $this->config['presets'][$presetName];
        } else {
            if ($presetName == 'default') {
                return null;
            } else {
                throw new \RuntimeException('Unknown preset specified: "' . $presetName . '".');
            }
        }
    }

    /**
     * @param array $preset
     * @param string $patternType
     * @return array
     */
    protected function getPatternsFromPreset($preset, $patternType)
    {
        if (!isset($preset[$patternType])) {
            return [];
        }

        return $preset[$patternType];
    }

    /**
     * @param array $patterns
     * @param string $routeName
     * @param array &$matches
     * @return bool
     */
    protected function isPatternsApplyToRouteName($patterns, $routeName, &$matches = null)
    {
        if (count($patterns)) {
            foreach ($patterns as $pattern) {
                if (preg_match($pattern['pattern'], $routeName, $matches)) {
                    return true;
                }
            }
        }

        return false;
    }
}