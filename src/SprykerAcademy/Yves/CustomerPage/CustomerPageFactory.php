<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace SprykerAcademy\Yves\CustomerPage;

use SprykerAcademy\Client\ContactRequest\ContactRequestClientInterface;
use SprykerAcademy\Yves\CustomerPage\Form\ContactRequestForm;
use SprykerShop\Yves\CustomerPage\CustomerPageFactory as SprykerCustomerPageFactory;
use Symfony\Component\Form\FormInterface;

class CustomerPageFactory extends SprykerCustomerPageFactory
{
    public function getContactRequestClient(): ContactRequestClientInterface
    {
        // TODO: Return the ContactRequestClient from the provided dependencies
        // Hint: $this->getProvidedDependency(CustomerPageDependencyProvider::CLIENT_CONTACT_REQUEST)
    }

    public function createContactRequestForm(): FormInterface
    {
        // TODO: Use the FormFactory to instantiate and return the ContactRequestForm
        // Hint: $this->createCustomerFormFactory()->getFormFactory()->create(ContactRequestForm::class)
    }
}
