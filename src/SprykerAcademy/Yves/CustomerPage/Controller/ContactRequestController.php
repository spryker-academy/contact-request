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
                'messages' => $contactRequestCollectionTransfer->getContactRequests(),
                'contactRequestForm' => $contactRequestForm->createView(),
            ],
            [],
            '@CustomerPage/views/message/list.twig',
        );
    }

    public function deleteAction(Request $request): RedirectResponse
    {
        $idMessage = $this->castId($request->request->get('idMessage'));

        $contactRequestCriteria = new ContactRequestCriteriaTransfer();
        $contactRequestCriteria->setIdContactRequest($idMessage);

        $this->getFactory()
            ->getContactRequestClient()
            ->deleteContactRequest($contactRequestCriteria);

        return $this->redirectResponseInternal(static::ROUTE_CUSTOMER_CONTACT_REQUESTS);
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

    protected function castId(mixed $id): int
    {
        if (!is_numeric($id) || $id == 0) {
            throw new \InvalidArgumentException('The given id is not numeric or is 0 (zero).');
        }

        return (int) $id;
    }
}
