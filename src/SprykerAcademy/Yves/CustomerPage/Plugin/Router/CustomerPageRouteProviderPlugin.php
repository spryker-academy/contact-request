<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace SprykerAcademy\Yves\CustomerPage\Plugin\Router;

use SprykerAcademy\Yves\CustomerPage\Controller\ContactRequestController;
use SprykerShop\Yves\CustomerPage\Plugin\Router\CustomerPageRouteProviderPlugin as SprykerCustomerPageRouteProviderPlugin;
use Spryker\Yves\Router\Route\RouteCollection;
use Symfony\Component\HttpFoundation\Request;

class CustomerPageRouteProviderPlugin extends SprykerCustomerPageRouteProviderPlugin
{
    public const string ROUTE_CUSTOMER_CONTACT_REQUESTS_DELETE = 'customer/messages/delete';

    public function addRoutes(RouteCollection $routeCollection): RouteCollection
    {
        $routeCollection = parent::addRoutes($routeCollection);
        $routeCollection = $this->addCustomerContactRequestsRoute($routeCollection);
        $routeCollection = $this->addCustomerContactRequestsDeleteRoute($routeCollection);

        return $routeCollection;
    }

    protected function addCustomerContactRequestsRoute(RouteCollection $routeCollection): RouteCollection
    {
        $route = $this->buildRoute('/customer/contact-requests', 'CustomerPage', 'Message', 'listAction');
        $route = $route->setMethods(['GET', 'POST']);
        $routeCollection->add(ContactRequestController::ROUTE_CUSTOMER_CONTACT_REQUESTS, $route);

        return $routeCollection;
    }

    protected function addCustomerContactRequestsDeleteRoute(RouteCollection $routeCollection): RouteCollection
    {
        $route = $this->buildRoute('/customer/contact-requests/delete', 'CustomerPage', 'Message', 'deleteAction');
        $route = $route->setMethods(Request::METHOD_POST);
        $routeCollection->add(static::ROUTE_CUSTOMER_CONTACT_REQUESTS_DELETE, $route);

        return $routeCollection;
    }
}
