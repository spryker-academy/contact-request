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
    public function findMessageAction(ContactRequestCriteriaTransfer $contactRequestCriteria): ContactRequestResponseTransfer
    {
        return $this->getFacade()->findContactRequest($contactRequestCriteria);
    }

    public function createMessageAction(ContactRequestTransfer $contactRequestTransfer): ContactRequestTransfer
    {
        return $this->getFacade()->createContactRequest($contactRequestTransfer);
    }

    public function getMessagesByCustomerAction(ContactRequestCriteriaTransfer $contactRequestCriteria): ContactRequestCollectionTransfer
    {
        return $this->getFacade()->findContactRequestsByCustomer($contactRequestCriteria);
    }

    public function deleteMessageAction(ContactRequestCriteriaTransfer $contactRequestCriteria): ContactRequestResponseTransfer
    {
        $responseTransfer = new ContactRequestResponseTransfer();
        $deleted = $this->getFacade()->deleteContactRequest($contactRequestCriteria->getIdContactRequest());
        $responseTransfer->setIsSuccessful($deleted);

        return $responseTransfer;
    }
}
