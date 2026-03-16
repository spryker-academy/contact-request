<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerAcademy\Zed\ContactRequest\Communication\Controller;

use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \SprykerAcademy\Zed\ContactRequest\Business\ContactRequestFacadeInterface getFacade()
 */
class ContactRequestController extends AbstractController
{
    public function addAction(Request $request)
    {
        $message = $request->query->get('message', 'Hello World');

        $contactRequestCriteriaTransfer = null;
        // TODO: Instantiate ContactRequestCriteriaTransfer and set the message
// Use the facade with the method $this->getFacadde() and calle findContactRequest() with the message criteria transfer
        //Assign the return value to
        $contactRequestTransfer = null;

        if (!$contactRequestTransfer) {
            // TODO: If there isn't a message with that name already,
            // create a ContactRequestTransfer and set the right message name
            // and persist it with the help of the method `$this->getFacade()->createContactRequest()`
        }

        return $this->viewResponse([
            'message' => $contactRequestTransfer,
        ]);
    }
}
