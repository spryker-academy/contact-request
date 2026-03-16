<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerAcademy\Zed\ContactRequest\Business;

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
        // TODO: Use the factory to create a ContactRequestWriter and use it to create a message
        // Hint: You can access the ContactRequestBusinessFactory through $this->getFactory()
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ContactRequestCriteriaTransfer $contactRequestCriteria
     *
     * @return \Generated\Shared\Transfer\ContactRequestResponseTransfer
     */
    public function findContactRequest(ContactRequestCriteriaTransfer $contactRequestCriteria): ContactRequestResponseTransfer
    {
        // TODO: Use the factory to create a ContactRequestReader and use it to find a message
    }
}
