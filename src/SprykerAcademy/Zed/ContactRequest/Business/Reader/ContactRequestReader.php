<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerAcademy\Zed\ContactRequest\Business\Reader;

use Generated\Shared\Transfer\ContactRequestCollectionTransfer;
use Generated\Shared\Transfer\ContactRequestCriteriaTransfer;
use Generated\Shared\Transfer\ContactRequestResponseTransfer;
use SprykerAcademy\Zed\ContactRequest\Persistence\ContactRequestRepositoryInterface;

class ContactRequestReader
{
    public function __construct(protected ContactRequestRepositoryInterface $contactRequestRepository)
    {
    }

    public function findContactRequest(ContactRequestCriteriaTransfer $contactRequestCriteria): ContactRequestResponseTransfer
    {
        $contactRequestTransfer = $this->contactRequestRepository->findContactRequest($contactRequestCriteria);
        $contactRequestResponseTransfer = new ContactRequestResponseTransfer();

        if ($contactRequestTransfer === null) {
            $contactRequestResponseTransfer->setIsSuccessful(false);
        } else {
            $contactRequestResponseTransfer->setIsSuccessful(true);
            $contactRequestResponseTransfer->setContactRequest($contactRequestTransfer);
        }

        return $contactRequestResponseTransfer;
    }

    public function findContactRequestsByCustomer(ContactRequestCriteriaTransfer $contactRequestCriteria): ContactRequestCollectionTransfer
    {
        // TODO: Step 1 - Use the repository to get the contact requests of this customer
        // TODO: Step 2 - Create a ContactRequestCollectionTransfer and add each one with addContactRequest()
        // TODO: Step 3 - Return the collection

        return new ContactRequestCollectionTransfer();
    }
}
