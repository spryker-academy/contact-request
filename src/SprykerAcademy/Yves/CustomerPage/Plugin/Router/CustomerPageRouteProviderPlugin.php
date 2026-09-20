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
    public const string ROUTE_CUSTOMER_CONTACT_REQUESTS_DELETE = 'customer/contact-requests/delete';

    public function addRoutes(RouteCollection $routeCollection): RouteCollection
    {
        $routeCollection = parent::addRoutes($routeCollection);
        $routeCollection = $this->addCustomerContactRequestsRoute($routeCollection);
        $routeCollection = $this->addCustomerContactRequestsDeleteRoute($routeCollection);

        return $routeCollection;
    }

    protected function addCustomerContactRequestsRoute(RouteCollection $routeCollection): RouteCollection
    {
        // TODO: Build a route for '/customer/contact-requests' pointing to CustomerPage module, ContactRequest controller, listAction
        // Hint: $route = $this->buildRoute('/customer/contact-requests', 'CustomerPage', 'ContactRequest', 'listAction');
        // TODO: Set allowed methods to GET and POST
        // Hint: $route = $route->setMethods(['GET', 'POST']);
        // TODO: Add the route to the collection using ContactRequestController::ROUTE_CUSTOMER_CONTACT_REQUESTS as the name
        // Hint: $routeCollection->add(ContactRequestController::ROUTE_CUSTOMER_CONTACT_REQUESTS, $route);

        return $routeCollection;
    }

    protected function addCustomerContactRequestsDeleteRoute(RouteCollection $routeCollection): RouteCollection
    {
        // TODO: Build a route for '/customer/contact-requests/delete' pointing to CustomerPage module,
        //       ContactRequest controller, deleteAction
        // TODO: Allow only POST - deleting is never a GET
        // Hint: $route = $route->setMethods(Request::METHOD_POST);
        // TODO: Add the route under static::ROUTE_CUSTOMER_CONTACT_REQUESTS_DELETE

        return $routeCollection;
    }
}
