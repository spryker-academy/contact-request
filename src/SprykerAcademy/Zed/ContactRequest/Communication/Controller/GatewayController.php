<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerAcademy\Zed\ContactRequest\Communication\Controller;

use Generated\Shared\Transfer\ContactRequestCollectionTransfer;
use Generated\Shared\Transfer\ContactRequestCriteriaTransfer;
use Generated\Shared\Transfer\ContactRequestResponseTransfer;
use Generated\Shared\Transfer\ContactRequestTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractGatewayController;

/**
 * @method \SprykerAcademy\Zed\ContactRequest\Business\ContactRequestFacadeInterface getFacade()
 */
class GatewayController extends AbstractGatewayController
{
    public function findContactRequestAction(ContactRequestCriteriaTransfer $contactRequestCriteria): ContactRequestResponseTransfer
    {
        return $this->getFacade()->findContactRequest($contactRequestCriteria);
    }

    public function createContactRequestAction(ContactRequestTransfer $contactRequestTransfer): ContactRequestTransfer
    {
        // TODO: Use the Facade to create the contact request and return it

        return $contactRequestTransfer;
    }

    public function getContactRequestsByCustomerAction(ContactRequestCriteriaTransfer $contactRequestCriteria): ContactRequestCollectionTransfer
    {
        // TODO: Use the Facade to find the contact requests of the customer and return the collection

        return new ContactRequestCollectionTransfer();
    }

    public function deleteContactRequestAction(ContactRequestCriteriaTransfer $contactRequestCriteria): ContactRequestResponseTransfer
    {
        // TODO: Use the Facade to delete the contact request by its id
        // TODO: Return a ContactRequestResponseTransfer carrying the isSuccessful flag

        return new ContactRequestResponseTransfer();
    }
}
