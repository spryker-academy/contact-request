<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace SprykerAcademy\Yves\CustomerPage\Controller;

use Generated\Shared\Transfer\ContactRequestCriteriaTransfer;
use Generated\Shared\Transfer\ContactRequestTransfer;
use SprykerShop\Yves\CustomerPage\Controller\AbstractCustomerController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \SprykerAcademy\Yves\CustomerPage\CustomerPageFactory getFactory()
 */
class ContactRequestAsyncController extends AbstractCustomerController
{
    protected const string FLASH_MESSAGE_LIST_TEMPLATE_PATH = '@ShopUi/components/organisms/flash-message-list/flash-message-list.twig';

    public function addAction(Request $request): JsonResponse
    {
        $contactRequestForm = $this->getFactory()->createContactRequestForm(new ContactRequestTransfer());
        $contactRequestForm->handleRequest($request);

        if (!$contactRequestForm->isSubmitted() || !$contactRequestForm->isValid()) {
            $this->addErrorMessage('Invalid form submission.');

            return $this->getMessagesJsonResponse();
        }

        $customerTransfer = $this->getLoggedInCustomerTransfer();

        /** @var \Generated\Shared\Transfer\ContactRequestTransfer $contactRequestTransfer */
        $contactRequestTransfer = $contactRequestForm->getData();
        $contactRequestTransfer->setFkCustomer($customerTransfer?->getIdCustomer());

        $this->getFactory()
            ->getContactRequestClient()
            ->createContactRequest($contactRequestTransfer);

        $this->addSuccessMessage('Contact request added successfully.');

        return $this->getContactRequestListJsonResponse($customerTransfer?->getIdCustomer());
    }

    public function deleteAction(Request $request): JsonResponse
    {
        $idContactRequest = $this->castId($request->request->get('idContactRequest'));

        $customerTransfer = $this->getLoggedInCustomerTransfer();
        $contactRequestCriteria = new ContactRequestCriteriaTransfer();
        $contactRequestCriteria->setIdContactRequest($idContactRequest);

        $response = $this->getFactory()
            ->getContactRequestClient()
            ->deleteContactRequest($contactRequestCriteria);

        if ($response->getIsSuccessful()) {
            $this->addSuccessMessage('Contact request deleted.');
        } else {
            $this->addErrorMessage('Could not delete the contact request.');
        }

        return $this->getContactRequestListJsonResponse($customerTransfer?->getIdCustomer());
    }

    protected function getMessagesJsonResponse(): JsonResponse
    {
        return $this->jsonResponse([
            'messages' => $this->renderView(static::FLASH_MESSAGE_LIST_TEMPLATE_PATH)->getContent(),
        ]);
    }

    protected function getContactRequestListJsonResponse(int $idCustomer): JsonResponse
    {
        $contactRequestCriteria = new ContactRequestCriteriaTransfer();
        $contactRequestCriteria->setFkCustomer($idCustomer);

        $contactRequestCollectionTransfer = $this->getFactory()
            ->getContactRequestClient()
            ->getContactRequestsByCustomer($contactRequestCriteria);

        $contactRequestForm = $this->getFactory()->createContactRequestForm(new ContactRequestTransfer());

        $content = $this->getTwig()->render(
            '@CustomerPage/views/contact-request/contact-request-async.twig',
            [
                'contactRequests' => $contactRequestCollectionTransfer->getContactRequests(),
                'contactRequestForm' => $contactRequestForm->createView(),
            ],
        );

        return $this->jsonResponse([
            'messages' => $this->renderView(static::FLASH_MESSAGE_LIST_TEMPLATE_PATH)->getContent(),
            'content' => $content,
        ]);
    }

    protected function castId(mixed $id): int
    {
        if (!is_numeric($id) || $id == 0) {
            throw new \InvalidArgumentException('The given id is not numeric or is 0 (zero).');
        }

        return (int) $id;
    }
}
