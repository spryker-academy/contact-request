<?php

declare(strict_types=1);

namespace SprykerAcademyTest\Zed\ContactRequest\Exercise4;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ContactRequestCriteriaTransfer;
use Generated\Shared\Transfer\ContactRequestResponseTransfer;
use Generated\Shared\Transfer\ContactRequestTransfer;
use SprykerAcademy\Zed\ContactRequest\Business\ContactRequestFacadeInterface;
use SprykerAcademy\Zed\ContactRequest\Communication\Controller\IndexController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Exercise 4, step 3.1: the Back Office controller.
 *
 * addAction() has to look a contact request up by the message from the query
 * string and, only when there is none, create one - then hand it to the view
 * under the key the template reads.
 *
 * Run: vendor/bin/codecept run -c tests/SprykerAcademyTest/Zed/ContactRequest/ Exercise4
 */
class IndexControllerAddActionTest extends Unit
{
    public function testAddActionLooksTheContactRequestUpByTheMessageFromTheQueryString(): void
    {
        // Arrange
        $facadeMock = $this->createMock(ContactRequestFacadeInterface::class);

        $criteriaSeenByTheFacade = null;
        $facadeMock->method('findContactRequest')
            ->willReturnCallback(function (ContactRequestCriteriaTransfer $criteria) use (&$criteriaSeenByTheFacade) {
                $criteriaSeenByTheFacade = $criteria;

                return (new ContactRequestResponseTransfer())->setIsSuccessful(false);
            });

        // Act
        (new IndexController($facadeMock))->addAction(Request::create('/contact-request/index/add?message=Norbert'));

        // Assert
        $this->assertInstanceOf(
            ContactRequestCriteriaTransfer::class,
            $criteriaSeenByTheFacade,
            'addAction() must call findContactRequest() with a ContactRequestCriteriaTransfer.',
        );
        $this->assertSame(
            'Norbert',
            $criteriaSeenByTheFacade->getMessage(),
            'The criteria must carry the "message" query parameter, not a hard-coded value.',
        );
    }

    public function testAddActionReturnsTheExistingContactRequestWithoutCreatingAnother(): void
    {
        // Arrange
        $existing = (new ContactRequestTransfer())->setIdContactRequest(7)->setMessage('Norbert');

        $facadeMock = $this->createMock(ContactRequestFacadeInterface::class);
        $facadeMock->method('findContactRequest')
            ->willReturn((new ContactRequestResponseTransfer())->setIsSuccessful(true)->setContactRequest($existing));
        $facadeMock->expects($this->never())
            ->method('createContactRequest');

        // Act
        $viewData = (new IndexController($facadeMock))
            ->addAction(Request::create('/contact-request/index/add?message=Norbert'));

        // Assert
        $this->assertArrayHasKey(
            'contactRequest',
            $viewData,
            'addAction() must pass the contact request to the view under the key "contactRequest".',
        );
        $this->assertSame(
            $existing,
            $viewData['contactRequest'],
            'When findContactRequest() found one, addAction() must return it unchanged.',
        );
    }

    public function testAddActionCreatesAContactRequestWhenNoneMatches(): void
    {
        // Arrange
        $persisted = (new ContactRequestTransfer())->setIdContactRequest(8)->setMessage('Norbert');

        $facadeMock = $this->createMock(ContactRequestFacadeInterface::class);
        $facadeMock->method('findContactRequest')
            ->willReturn((new ContactRequestResponseTransfer())->setIsSuccessful(false));
        $facadeMock->expects($this->once())
            ->method('createContactRequest')
            ->with($this->callback(static function (ContactRequestTransfer $contactRequestTransfer): bool {
                return $contactRequestTransfer->getMessage() === 'Norbert';
            }))
            ->willReturn($persisted);

        // Act
        $viewData = (new IndexController($facadeMock))
            ->addAction(Request::create('/contact-request/index/add?message=Norbert'));

        // Assert
        $this->assertSame(
            $persisted,
            $viewData['contactRequest'] ?? null,
            'addAction() must return the transfer that createContactRequest() gave back - '
            . 'that is the one carrying the new idContactRequest.',
        );
    }
}
