<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace SprykerAcademy\Client\ContactRequest\Stub;

use Generated\Shared\Transfer\ContactRequestCollectionTransfer;
use Generated\Shared\Transfer\ContactRequestCriteriaTransfer;
use Generated\Shared\Transfer\ContactRequestResponseTransfer;
use Generated\Shared\Transfer\ContactRequestTransfer;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;

class ContactRequestStub
{
    /**
     * @var \Spryker\Client\ZedRequest\ZedRequestClientInterface
     */
    protected ZedRequestClientInterface $zedRequestClient;

    /**
     * @param \Spryker\Client\ZedRequest\ZedRequestClientInterface $zedRequestClient
     */
    public function __construct(ZedRequestClientInterface $zedRequestClient)
    {
        $this->zedRequestClient = $zedRequestClient;
    }

    public function findContactRequest(ContactRequestCriteriaTransfer $contactRequestCriteria): ContactRequestResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\ContactRequestResponseTransfer $contactRequestResponseTransfer */
        $contactRequestResponseTransfer = $this->zedRequestClient->call('/contact-request/gateway/find-contact-request', $contactRequestCriteria);

        return $contactRequestResponseTransfer;
    }

    public function createContactRequest(ContactRequestTransfer $contactRequestTransfer): ContactRequestTransfer
    {
        // TODO: Call $this->zedRequestClient->call() with the path of createContactRequestAction()
        //        The convention is /module-name/gateway/action-name in kebab-case

        return $contactRequestTransfer;
    }

    public function getContactRequestsByCustomer(ContactRequestCriteriaTransfer $contactRequestCriteria): ContactRequestCollectionTransfer
    {
        // TODO: Call $this->zedRequestClient->call() with the path of getContactRequestsByCustomerAction()

        return new ContactRequestCollectionTransfer();
    }

    public function deleteContactRequest(ContactRequestCriteriaTransfer $contactRequestCriteria): ContactRequestResponseTransfer
    {
        // TODO: Call $this->zedRequestClient->call() with the path of deleteContactRequestAction()

        return new ContactRequestResponseTransfer();
    }
}
