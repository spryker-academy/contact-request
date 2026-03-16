<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace SprykerAcademy\Yves\CustomerPage\Controller;

use Generated\Shared\Transfer\ContactRequestCriteriaTransfer;
use Generated\Shared\Transfer\ContactRequestTransfer;
use SprykerAcademy\Yves\CustomerPage\Form\ContactRequestForm;
use SprykerShop\Yves\CustomerPage\Controller\AbstractCustomerController;
use Spryker\Yves\Kernel\View\View;
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
        // TODO: Step 1 - Get the logged-in customer using $this->getLoggedInCustomerTransfer()
        // TODO: Step 2 - Create a ContactRequestCriteriaTransfer and set fkCustomer from the customer's ID
        // TODO: Step 3 - Use getFactory()->getContactRequestClient()->getContactRequestsByCustomer() to fetch messages
        // TODO: Step 4 - Create the message form using getFactory()->createContactRequestForm()
        // TODO: Step 5 - Handle the request with $contactRequestForm->handleRequest($request)
        // TODO: Step 6 - If form is submitted and valid, call handleContactRequestFormSubmit()
        // TODO: Step 7 - Return $this->view() with 'messages' and 'contactRequestForm' variables
        //        Template: '@CustomerPage/views/message/list.twig'

        return [];
    }

    protected function handleContactRequestFormSubmit($contactRequestForm, int $idCustomer): RedirectResponse
    {
        // TODO: Get form data, create a ContactRequestTransfer with the message text and fkCustomer
        // TODO: Use getFactory()->getContactRequestClient()->createContactRequest() to persist it
        // TODO: Redirect back to the messages list using $this->redirectResponseInternal(static::ROUTE_CUSTOMER_CONTACT_REQUESTS)

        return $this->redirectResponseInternal(static::ROUTE_CUSTOMER_CONTACT_REQUESTS);
    }
}
