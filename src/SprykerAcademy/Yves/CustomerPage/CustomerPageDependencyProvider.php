<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace SprykerAcademy\Yves\CustomerPage;

use Spryker\Yves\Kernel\Container;
use SprykerShop\Yves\CustomerPage\CustomerPageDependencyProvider as SprykerCustomerPageDependencyProvider;

class CustomerPageDependencyProvider extends SprykerCustomerPageDependencyProvider
{
    public const string CLIENT_CONTACT_REQUEST = 'CLIENT_CONTACT_REQUEST';

    public function provideDependencies(Container $container): Container
    {
        $container = parent::provideDependencies($container);
        $container = $this->addContactRequestClient($container);

        return $container;
    }

    protected function addContactRequestClient(Container $container): Container
    {
        // TODO: Use $container->set() with the CLIENT_CONTACT_REQUEST constant to provide the ContactRequestClient
        // Hint: $container->set(static::CLIENT_CONTACT_REQUEST, fn () => $container->getLocator()->contactRequest()->client())

        return $container;
    }
}
