<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace SprykerAcademy\Yves\CustomerPage\Controller;

use Generated\Shared\Transfer\ContactRequestCriteriaTransfer;
use Generated\Shared\Transfer\ContactRequestTransfer;
use Spryker\Yves\Kernel\View\View;
use SprykerShop\Yves\CustomerPage\Controller\AbstractCustomerController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \SprykerAcademy\Yves\CustomerPage\CustomerPageFactory getFactory()
 */
class ContactRequestController extends AbstractCustomerController
{
    public const string ROUTE_CUSTOMER_CONTACT_REQUESTS = 'customer/messages';

    public function listAction(Request $request): View|RedirectResponse
    {
        $customerTransfer = $this->getLoggedInCustomerTransfer();
        $fkCustomer = $customerTransfer?->getIdCustomer();

        $contactRequestCriteria = new ContactRequestCriteriaTransfer();
        $contactRequestCriteria->setFkCustomerOrFail($fkCustomer);

        $contactRequestCollectionTransfer = $this->getFactory()
            ->getContactRequestClient()
            ->getContactRequestsByCustomer($contactRequestCriteria);

        $contactRequestTransfer = new ContactRequestTransfer();
        $contactRequestForm = $this->getFactory()->createContactRequestForm($contactRequestTransfer);
        $contactRequestForm->handleRequest($request);

        if ($contactRequestForm->isSubmitted() && $contactRequestForm->isValid()) {
            return $this->handleContactRequestFormSubmit($contactRequestForm, $fkCustomer);
        }

        return $this->view(
            [
                'contactRequests' => $contactRequestCollectionTransfer->getContactRequests(),
                'contactRequestForm' => $contactRequestForm->createView(),
            ],
            [],
            '@CustomerPage/views/contact-request/list.twig',
        );
    }

    protected function handleContactRequestFormSubmit($contactRequestForm, int $idCustomer): RedirectResponse
    {
        /** @var \Generated\Shared\Transfer\ContactRequestTransfer $contactRequestTransfer */
        $contactRequestTransfer = $contactRequestForm->getData();
        $contactRequestTransfer->setFkCustomer($idCustomer);

        $this->getFactory()
            ->getContactRequestClient()
            ->createContactRequest($contactRequestTransfer);

        return $this->redirectResponseInternal(static::ROUTE_CUSTOMER_CONTACT_REQUESTS);
    }
}
