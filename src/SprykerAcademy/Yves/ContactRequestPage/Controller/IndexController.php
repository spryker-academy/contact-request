<?php

namespace SprykerAcademy\Yves\ContactRequestPage\Controller;

use Generated\Shared\Transfer\ContactRequestCriteriaTransfer;
use Spryker\Yves\Kernel\View\View;
use SprykerShop\Yves\ShopApplication\Controller\AbstractController;

/**
 * @method \SprykerAcademy\Yves\ContactRequestPage\ContactRequestPageFactory getFactory()
 */
class IndexController extends AbstractController
{
    public function getAction(int $idContactRequest): View
    {
        $contactRequestCriteriaTransfer = null;
        // TODO: Instantiate ContactRequestCriteriaTransfer and set the contact request ID from the route parameter

        $contactRequestResponseTransfer = null;
        // TODO: Use the ContactRequestClient which is accessible by using `$this->getFactory()`
        // to find a contact request by a ContactRequestCriteriaTransfer

        return $this->view(
            ['contactRequest' => $contactRequestResponseTransfer->getContactRequest()],
            [],
            '@ContactRequestPage/views/contact-request/get.twig'
        );
    }
}
