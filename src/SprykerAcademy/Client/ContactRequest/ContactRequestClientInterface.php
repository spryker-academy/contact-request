<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace SprykerAcademy\Client\ContactRequest;

use Generated\Shared\Transfer\ContactRequestCollectionTransfer;
use Generated\Shared\Transfer\ContactRequestCriteriaTransfer;
use Generated\Shared\Transfer\ContactRequestResponseTransfer;
use Generated\Shared\Transfer\ContactRequestTransfer;

interface ContactRequestClientInterface
{
    /**
     * Specification:
     * - Finds message by defined criteria
     * - Returns a response-transfer which can hold a message if one is found
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ContactRequestCriteriaTransfer $contactRequestCriteria
     *
     * @return \Generated\Shared\Transfer\ContactRequestResponseTransfer
     */
    public function findContactRequest(ContactRequestCriteriaTransfer $contactRequestCriteria): ContactRequestResponseTransfer;

    /**
     * Specification:
     * - Creates a new message via Zed
     * - Returns the persisted message transfer with ID
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ContactRequestTransfer $contactRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ContactRequestTransfer
     */
    public function createContactRequest(ContactRequestTransfer $contactRequestTransfer): ContactRequestTransfer;

    /**
     * Specification:
     * - Finds all messages for a given customer
     * - Returns a collection of message transfers
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ContactRequestCriteriaTransfer $contactRequestCriteria
     *
     * @return \Generated\Shared\Transfer\ContactRequestCollectionTransfer
     */
    public function getContactRequestsByCustomer(ContactRequestCriteriaTransfer $contactRequestCriteria): ContactRequestCollectionTransfer;

    /**
     * Specification:
     * - Deletes a message by ID via Zed
     * - Returns response with isSuccessful flag
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ContactRequestCriteriaTransfer $contactRequestCriteria
     *
     * @return \Generated\Shared\Transfer\ContactRequestResponseTransfer
     */
    public function deleteContactRequest(ContactRequestCriteriaTransfer $contactRequestCriteria): ContactRequestResponseTransfer;
}
