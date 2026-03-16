<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerAcademy\Zed\ContactRequest\Business\Deleter;

use SprykerAcademy\Zed\ContactRequest\Persistence\ContactRequestEntityManagerInterface;

class ContactRequestDeleter
{
    public function __construct(protected ContactRequestEntityManagerInterface $contactRequestEntityManager)
    {
    }

    public function delete(int $idMessage): bool
    {
        return $this->contactRequestEntityManager->deleteContactRequest($idMessage);
    }
}
