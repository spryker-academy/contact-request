<?php

declare(strict_types=1);

namespace SprykerAcademy\Yves\Router;

use Pyz\Yves\Router\RouterDependencyProvider as PyzRouterDependencyProvider;
use SprykerAcademy\Yves\ContactRequestPage\Plugin\Router\ContactRequestPageRouteProviderPlugin;

/**
 * SprykerAcademy is resolved before Pyz (see KernelConstants::PROJECT_NAMESPACES), so this class replaces the
 * project's RouterDependencyProvider without editing it. It keeps every Pyz route and adds the exercise routes.
 */
class RouterDependencyProvider extends PyzRouterDependencyProvider
{
    /**
     * @return array<\Spryker\Yves\RouterExtension\Dependency\Plugin\RouteProviderPluginInterface>
     */
    protected function getRouteProvider(): array
    {
        $routeProviderPlugins = parent::getRouteProvider();
        $routeProviderPlugins[] = new ContactRequestPageRouteProviderPlugin();

        return $routeProviderPlugins;
    }
}
