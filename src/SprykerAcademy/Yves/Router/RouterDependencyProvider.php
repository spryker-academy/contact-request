<?php

declare(strict_types=1);

namespace SprykerAcademy\Yves\Router;

use Pyz\Yves\Router\RouterDependencyProvider as PyzRouterDependencyProvider;
use SprykerAcademy\Yves\ContactRequestPage\Plugin\Router\ContactRequestPageRouteProviderPlugin;
use SprykerAcademy\Yves\CustomerPage\Plugin\Router\CustomerPageRouteProviderPlugin;
use SprykerShop\Yves\CustomerPage\Plugin\Router\CustomerPageRouteProviderPlugin as SprykerShopCustomerPageRouteProviderPlugin;

/**
 * SprykerAcademy is resolved before Pyz (see KernelConstants::PROJECT_NAMESPACES), so this class replaces the
 * project's RouterDependencyProvider without editing it. It keeps every Pyz route, adds the exercise routes and
 * swaps the core CustomerPage route provider for the extended one of this exercise.
 */
class RouterDependencyProvider extends PyzRouterDependencyProvider
{
    /**
     * @return array<\Spryker\Yves\RouterExtension\Dependency\Plugin\RouteProviderPluginInterface>
     */
    protected function getRouteProvider(): array
    {
        $routeProviderPlugins = parent::getRouteProvider();

        foreach ($routeProviderPlugins as $index => $routeProviderPlugin) {
            if ($routeProviderPlugin instanceof SprykerShopCustomerPageRouteProviderPlugin) {
                $routeProviderPlugins[$index] = new CustomerPageRouteProviderPlugin();
            }
        }

        $routeProviderPlugins[] = new ContactRequestPageRouteProviderPlugin();

        return $routeProviderPlugins;
    }
}
