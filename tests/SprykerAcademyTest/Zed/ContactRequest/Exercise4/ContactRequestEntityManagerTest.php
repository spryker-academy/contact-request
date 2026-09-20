<?php

declare(strict_types=1);

namespace SprykerAcademyTest\Zed\ContactRequest\Exercise4;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ContactRequestTransfer;
use Orm\Zed\ContactRequest\Persistence\PyzContactRequest;
use SprykerAcademy\Zed\ContactRequest\Persistence\ContactRequestEntityManager;
use SprykerAcademy\Zed\ContactRequest\Persistence\ContactRequestPersistenceFactory;
use SprykerAcademy\Zed\ContactRequest\Persistence\Mapper\ContactRequestMapper;

/**
 * Exercise 4, step 1.4: the EntityManager.
 *
 * createContactRequest() has to map the transfer to an entity with the Mapper,
 * save it, and map the saved entity back - the way round trip that gives the
 * caller the generated idContactRequest.
 *
 * The Mapper is mocked and hands back a mocked entity, so save() touches no
 * database.
 *
 * Run: vendor/bin/codecept run -c tests/SprykerAcademyTest/Zed/ContactRequest/ Exercise4
 */
class ContactRequestEntityManagerTest extends Unit
{
    public function testCreateContactRequestMapsSavesAndMapsBack(): void
    {
        // Arrange
        $incoming = (new ContactRequestTransfer())->setMessage('Norbert');
        $persisted = (new ContactRequestTransfer())->setIdContactRequest(7)->setMessage('Norbert');

        $entityMock = $this->createMock(PyzContactRequest::class);
        $entityMock->expects($this->once())
            ->method('save')
            ->willReturn(1);

        $mapperMock = $this->createMock(ContactRequestMapper::class);
        $mapperMock->expects($this->once())
            ->method('mapContactRequestTransferToEntity')
            ->with($incoming, $this->isInstanceOf(PyzContactRequest::class))
            ->willReturn($entityMock);
        $mapperMock->expects($this->once())
            ->method('mapEntityToContactRequestTransfer')
            ->with($entityMock, $this->isInstanceOf(ContactRequestTransfer::class))
            ->willReturn($persisted);

        $entityManager = $this->createEntityManager($mapperMock);

        // Act
        $result = $entityManager->createContactRequest($incoming);

        // Assert
        $this->assertSame(
            $persisted,
            $result,
            'createContactRequest() must return the transfer the Mapper built from the saved entity, '
            . 'not a fresh empty one - that is where the new idContactRequest comes from.',
        );
    }

    private function createEntityManager(ContactRequestMapper $mapper): ContactRequestEntityManager
    {
        $factoryMock = $this->getMockBuilder(ContactRequestPersistenceFactory::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['createContactRequestMapper'])
            ->getMock();
        $factoryMock->method('createContactRequestMapper')->willReturn($mapper);

        $entityManager = new ContactRequestEntityManager();
        $entityManager->setFactory($factoryMock);

        return $entityManager;
    }
}
