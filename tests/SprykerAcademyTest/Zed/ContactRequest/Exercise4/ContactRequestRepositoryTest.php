<?php

declare(strict_types=1);

namespace SprykerAcademyTest\Zed\ContactRequest\Exercise4;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ContactRequestCriteriaTransfer;
use Generated\Shared\Transfer\ContactRequestTransfer;
use Orm\Zed\ContactRequest\Persistence\PyzContactRequest;
use Orm\Zed\ContactRequest\Persistence\PyzContactRequestQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use SprykerAcademy\Zed\ContactRequest\Persistence\ContactRequestPersistenceFactory;
use SprykerAcademy\Zed\ContactRequest\Persistence\ContactRequestRepository;
use SprykerAcademy\Zed\ContactRequest\Persistence\Mapper\ContactRequestMapper;

/**
 * Exercise 4, step 1.3: the Repository.
 *
 * findContactRequest() has to look up by id when the criteria carries one,
 * fall back to a partial match on the message, return null when nothing is
 * found, and never hand an entity out of the Persistence layer.
 *
 * The Propel query and the Mapper are mocked, so no database is involved.
 *
 * Run: vendor/bin/codecept run -c tests/SprykerAcademyTest/Zed/ContactRequest/ Exercise4
 */
class ContactRequestRepositoryTest extends Unit
{
    public function testFindContactRequestLooksUpByIdWhenTheCriteriaHasOne(): void
    {
        // Arrange
        $entity = new PyzContactRequest();
        $queryMock = $this->createQueryMock();
        $queryMock->expects($this->once())
            ->method('findOneByIdContactRequest')
            ->with(7)
            ->willReturn($entity);
        $queryMock->expects($this->never())
            ->method('filterByMessage');

        $repository = $this->createRepository($queryMock, $this->createPassThroughMapper());

        // Act
        $result = $repository->findContactRequest((new ContactRequestCriteriaTransfer())->setIdContactRequest(7));

        // Assert
        $this->assertInstanceOf(
            ContactRequestTransfer::class,
            $result,
            'findContactRequest() must return a ContactRequestTransfer, never the Propel entity.',
        );
    }

    public function testFindContactRequestMatchesTheMessagePartially(): void
    {
        // Arrange
        $queryMock = $this->createQueryMock();
        $queryMock->expects($this->never())
            ->method('findOneByIdContactRequest');
        $queryMock->expects($this->once())
            ->method('filterByMessage')
            ->with('%Norbert%', Criteria::LIKE)
            ->willReturnSelf();
        $queryMock->expects($this->once())
            ->method('findOne')
            ->willReturn(new PyzContactRequest());

        $repository = $this->createRepository($queryMock, $this->createPassThroughMapper());

        // Act
        $result = $repository->findContactRequest((new ContactRequestCriteriaTransfer())->setMessage('Norbert'));

        // Assert
        $this->assertInstanceOf(
            ContactRequestTransfer::class,
            $result,
            'A message lookup must wrap the value in % and pass Criteria::LIKE, then findOne().',
        );
    }

    public function testFindContactRequestReturnsNullWhenNothingMatches(): void
    {
        // Arrange
        $queryMock = $this->createQueryMock();
        $queryMock->method('findOneByIdContactRequest')->willReturn(null);

        $mapperMock = $this->createMock(ContactRequestMapper::class);
        $mapperMock->expects($this->never())
            ->method('mapEntityToContactRequestTransfer');

        $repository = $this->createRepository($queryMock, $mapperMock);

        // Act
        $result = $repository->findContactRequest((new ContactRequestCriteriaTransfer())->setIdContactRequest(999));

        // Assert
        $this->assertNull(
            $result,
            'findContactRequest() must return null when the query found nothing.',
        );
    }

    public function testFindContactRequestMapsTheEntityThroughTheMapper(): void
    {
        // Arrange
        $entity = new PyzContactRequest();
        $mapped = (new ContactRequestTransfer())->setIdContactRequest(7)->setMessage('Norbert');

        $queryMock = $this->createQueryMock();
        $queryMock->method('findOneByIdContactRequest')->willReturn($entity);

        $mapperMock = $this->createMock(ContactRequestMapper::class);
        $mapperMock->expects($this->once())
            ->method('mapEntityToContactRequestTransfer')
            ->with($entity, $this->isInstanceOf(ContactRequestTransfer::class))
            ->willReturn($mapped);

        $repository = $this->createRepository($queryMock, $mapperMock);

        // Act
        $result = $repository->findContactRequest((new ContactRequestCriteriaTransfer())->setIdContactRequest(7));

        // Assert
        $this->assertSame(
            $mapped,
            $result,
            'findContactRequest() must return what the ContactRequestMapper produced.',
        );
    }

    /**
     * findOneBy<Column>() is answered by Propel's __call(), so PHPUnit has nothing to
     * stub. ContactRequestQueryDouble below declares it; filterByMessage() and
     * findOne() are really generated on the query class.
     */
    private function createQueryMock(): PyzContactRequestQuery
    {
        return $this->createMock(ContactRequestQueryDouble::class);
    }

    private function createRepository(
        PyzContactRequestQuery $query,
        ContactRequestMapper $mapper,
    ): ContactRequestRepository {
        $factoryMock = $this->getMockBuilder(ContactRequestPersistenceFactory::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['createContactRequestQuery', 'createContactRequestMapper'])
            ->getMock();
        $factoryMock->method('createContactRequestQuery')->willReturn($query);
        $factoryMock->method('createContactRequestMapper')->willReturn($mapper);

        $repository = new ContactRequestRepository();
        $repository->setFactory($factoryMock);

        return $repository;
    }

    private function createPassThroughMapper(): ContactRequestMapper
    {
        $mapperMock = $this->createMock(ContactRequestMapper::class);
        $mapperMock->method('mapEntityToContactRequestTransfer')
            ->willReturn(new ContactRequestTransfer());

        return $mapperMock;
    }
}

/**
 * Propel answers findOneByIdContactRequest() through __call(), which a mock cannot
 * intercept. Declaring it on an abstract subclass gives PHPUnit something to stub
 * while the double stays a real PyzContactRequestQuery for the Repository.
 */
abstract class ContactRequestQueryDouble extends PyzContactRequestQuery
{
    /**
     * @param mixed $idContactRequest
     */
    abstract public function findOneByIdContactRequest($idContactRequest): ?PyzContactRequest;
}
