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
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \SprykerAcademy\Zed\ContactRequest\Business\ContactRequestBusinessFactory getFactory()
 */
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
        return $this->getFactory()->createContactRequestWriter()->create($contactRequestTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     */
    public function findContactRequest(ContactRequestCriteriaTransfer $contactRequestCriteria): ContactRequestResponseTransfer
    {
        return $this->getFactory()->createContactRequestReader()->findContactRequest($contactRequestCriteria);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     */
    public function findContactRequestsByCustomer(ContactRequestCriteriaTransfer $contactRequestCriteria): ContactRequestCollectionTransfer
    {
        return $this->getFactory()->createContactRequestReader()->findContactRequestsByCustomer($contactRequestCriteria);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     */
    public function deleteContactRequest(int $idMessage): bool
    {
        return $this->getFactory()->createContactRequestDeleter()->delete($idMessage);
    }
}
