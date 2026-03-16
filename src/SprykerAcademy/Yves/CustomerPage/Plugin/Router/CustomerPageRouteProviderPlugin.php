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

class CustomerPageRouteProviderPlugin extends SprykerCustomerPageRouteProviderPlugin
{
    public function addRoutes(RouteCollection $routeCollection): RouteCollection
    {
        $routeCollection = parent::addRoutes($routeCollection);
        $routeCollection = $this->addCustomerContactRequestsRoute($routeCollection);

        return $routeCollection;
    }

    protected function addCustomerContactRequestsRoute(RouteCollection $routeCollection): RouteCollection
    {
        // TODO: Build a route for '/customer/contact-requests' pointing to CustomerPage module, Message controller, listAction
        // Hint: $route = $this->buildRoute('/customer/contact-requests', 'CustomerPage', 'Message', 'listAction');
        // TODO: Set allowed methods to GET and POST
        // Hint: $route = $route->setMethods(['GET', 'POST']);
        // TODO: Add the route to the collection using ContactRequestController::ROUTE_CUSTOMER_CONTACT_REQUESTS as the name
        // Hint: $routeCollection->add(ContactRequestController::ROUTE_CUSTOMER_CONTACT_REQUESTS, $route);

        return $routeCollection;
    }
}
