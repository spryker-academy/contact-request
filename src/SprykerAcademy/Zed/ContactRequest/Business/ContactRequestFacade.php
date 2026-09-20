<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerAcademy\Zed\ContactRequest\Business;

use Generated\Shared\Transfer\ContactRequestCollectionTransfer;
use Generated\Shared\Transfer\ContactRequestCriteriaTransfer;
use Generated\Shared\Transfer\ContactRequestResponseTransfer;
use Generated\Shared\Transfer\ContactRequestTransfer;
use SprykerAcademy\Zed\ContactRequest\Business\Deleter\ContactRequestDeleter;
use SprykerAcademy\Zed\ContactRequest\Business\Reader\ContactRequestReader;
use SprykerAcademy\Zed\ContactRequest\Business\Writer\ContactRequestWriter;
use Spryker\Zed\Kernel\Business\AbstractFacade;

class ContactRequestFacade extends AbstractFacade implements ContactRequestFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ContactRequestTransfer $contactRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ContactRequestTransfer
     */
    public function createContactRequest(ContactRequestTransfer $contactRequestTransfer): ContactRequestTransfer
    {
        return $this->getService(ContactRequestWriter::class)->create($contactRequestTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     */
    public function findContactRequest(ContactRequestCriteriaTransfer $contactRequestCriteria): ContactRequestResponseTransfer
    {
        return $this->getService(ContactRequestReader::class)->findContactRequest($contactRequestCriteria);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     */
    public function findContactRequestsByCustomer(ContactRequestCriteriaTransfer $contactRequestCriteria): ContactRequestCollectionTransfer
    {
        return $this->getService(ContactRequestReader::class)->findContactRequestsByCustomer($contactRequestCriteria);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     */
    public function deleteContactRequest(int $idContactRequest): bool
    {
        return $this->getService(ContactRequestDeleter::class)->delete($idContactRequest);
    }
}
