<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace SprykerAcademy\Zed\ContactRequest\Communication\Controller;

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
        return $this->getFacade()->createContactRequest($contactRequestTransfer);
    }
}
