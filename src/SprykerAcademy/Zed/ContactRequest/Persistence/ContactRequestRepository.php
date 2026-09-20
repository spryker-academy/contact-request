<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerAcademy\Zed\ContactRequest\Persistence;

use Generated\Shared\Transfer\ContactRequestCriteriaTransfer;
use Generated\Shared\Transfer\ContactRequestTransfer;
use Propel\Runtime\ActiveQuery\Criteria;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \SprykerAcademy\Zed\ContactRequest\Persistence\ContactRequestPersistenceFactory getFactory()
 */
class ContactRequestRepository extends AbstractRepository implements ContactRequestRepositoryInterface
{
    public function findContactRequest(ContactRequestCriteriaTransfer $contactRequestCriteria): ?ContactRequestTransfer
    {
        $query = $this->getFactory()->createContactRequestQuery();
        $contactRequestEntity = null;
        if ($contactRequestCriteria->getIdContactRequest()) {
            $contactRequestEntity = $query->findOneByIdContactRequest($contactRequestCriteria->getIdContactRequest());
        } elseif ($contactRequestCriteria->getMessage()) {
            $contactRequestEntity = $query->filterByMessage('%' . $contactRequestCriteria->getMessage() . '%', Criteria::LIKE)->findOne();
        }
        if (!$contactRequestEntity) {
            return null;
        }

        return $this->getFactory()->createContactRequestMapper()->mapEntityToContactRequestTransfer($contactRequestEntity, new ContactRequestTransfer());
    }

    /**
     * @param \Generated\Shared\Transfer\ContactRequestCriteriaTransfer $contactRequestCriteria
     *
     * @return array<\Generated\Shared\Transfer\ContactRequestTransfer>
     */
    public function findContactRequestsByCustomer(ContactRequestCriteriaTransfer $contactRequestCriteria): array
    {
        // TODO: Step 1 - Get the contact request query from the factory
        // TODO: Step 2 - Filter by fk_customer when the criteria has a fkCustomer set
        //        Hint: Propel generates filterBy<ColumnName>() on every query object
        // TODO: Step 3 - Execute the query with find()
        // TODO: Step 4 - Map every entity to a ContactRequestTransfer with the ContactRequestMapper
        // TODO: Step 5 - Return the array of ContactRequestTransfer objects

        return [];
    }
}
