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
class MessageAsyncController extends AbstractCustomerController
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

        $this->addSuccessMessage('Message added successfully.');

        return $this->getMessageListJsonResponse($customerTransfer?->getIdCustomer());
    }

    public function deleteAction(Request $request): JsonResponse
    {
        $idMessage = $this->castId($request->request->get('idMessage'));

        $customerTransfer = $this->getLoggedInCustomerTransfer();
        $contactRequestCriteria = new ContactRequestCriteriaTransfer();
        $contactRequestCriteria->setIdContactRequest($idMessage);

        $response = $this->getFactory()
            ->getContactRequestClient()
            ->deleteContactRequest($contactRequestCriteria);

        if ($response->getIsSuccessful()) {
            $this->addSuccessMessage('Message deleted.');
        } else {
            $this->addErrorMessage('Could not delete message.');
        }

        return $this->getMessageListJsonResponse($customerTransfer?->getIdCustomer());
    }

    protected function getMessagesJsonResponse(): JsonResponse
    {
        return $this->jsonResponse([
            'messages' => $this->renderView(static::FLASH_MESSAGE_LIST_TEMPLATE_PATH)->getContent(),
        ]);
    }

    protected function getMessageListJsonResponse(int $idCustomer): JsonResponse
    {
        $contactRequestCriteria = new ContactRequestCriteriaTransfer();
        $contactRequestCriteria->setFkCustomer($idCustomer);

        $contactRequestCollectionTransfer = $this->getFactory()
            ->getContactRequestClient()
            ->getContactRequestsByCustomer($contactRequestCriteria);

        $contactRequestForm = $this->getFactory()->createContactRequestForm(new ContactRequestTransfer());

        $content = $this->getTwig()->render(
            '@CustomerPage/views/contact-request/message-async.twig',
            [
                'messages' => $contactRequestCollectionTransfer->getContactRequests(),
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
