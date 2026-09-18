<?php

namespace SprykerAcademy\Yves\ContactRequestPage\Plugin\Router;

use Spryker\Yves\Router\Plugin\RouteProvider\AbstractRouteProviderPlugin;
use Spryker\Yves\Router\Route\RouteCollection;

class ContactRequestPageRouteProviderPlugin extends AbstractRouteProviderPlugin
{
    public const string ROUTE_NAME_CONTACT_REQUEST = 'contact-request/message/_idMessage_';

    public function addRoutes(RouteCollection $routeCollection): RouteCollection
    {
        $routeCollection = $this->addContactRequestMessageGetRoute($routeCollection);

        return $routeCollection;
    }

    private function addContactRequestMessageGetRoute(RouteCollection $routeCollection): RouteCollection
    {
        $route = $this->buildRoute('contact-request/{idMessage}', 'ContactRequestPage', 'Index', 'getAction');
        $route = $route->setMethods(['GET']);
        $routeCollection->add(static::ROUTE_NAME_CONTACT_REQUEST, $route);

        return $routeCollection;
    }
}
