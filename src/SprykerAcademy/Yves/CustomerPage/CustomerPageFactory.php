<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace SprykerAcademy\Yves\CustomerPage;

use Generated\Shared\Transfer\ContactRequestTransfer;
use SprykerAcademy\Client\ContactRequest\ContactRequestClientInterface;
use SprykerAcademy\Yves\CustomerPage\Form\ContactRequestForm;
use Pyz\Yves\CustomerPage\CustomerPageFactory as PyzCustomerPageFactory;
use Symfony\Component\Form\FormInterface;

class CustomerPageFactory extends PyzCustomerPageFactory
{
    public function getContactRequestClient(): ContactRequestClientInterface
    {
        // TODO: Return the ContactRequestClient from the provided dependencies
        // Hint: $this->getProvidedDependency(CustomerPageDependencyProvider::CLIENT_CONTACT_REQUEST)
    }

    public function createContactRequestForm(ContactRequestTransfer $contactRequestTransfer): FormInterface
    {
        // TODO: Use the FormFactory to instantiate and return the ContactRequestForm, bound to $contactRequestTransfer
        // Hint: $this->createCustomerFormFactory()->getFormFactory()->create(ContactRequestForm::class, $contactRequestTransfer)
    }
}
