<?php

declare(strict_types=1);

namespace SprykerAcademyTest\Zed\ContactRequest\Exercise7;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ContactRequestCollectionTransfer;
use Generated\Shared\Transfer\ContactRequestCriteriaTransfer;
use Generated\Shared\Transfer\ContactRequestResponseTransfer;
use Generated\Shared\Transfer\ContactRequestTransfer;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;
use SprykerAcademy\Client\ContactRequest\Stub\ContactRequestStub;
use SprykerAcademy\Zed\ContactRequest\Business\Deleter\ContactRequestDeleter;
use SprykerAcademy\Zed\ContactRequest\Persistence\ContactRequestEntityManagerInterface;

/**
 * Exercise 7: Extending Core Modules - Customer Messages
 *
 * Verifies schema modifications, transfer updates, gateway exposure,
 * client communication, and CustomerPage extension.
 *
 * Run: vendor/bin/codecept run -c tests/SprykerAcademyTest/Zed/ContactRequest/ Exercise7
 */
class ExtendingCoreModulesTest extends Unit
{
    // --- Part 1: Schema XML ---

    public function testSchemaHasFkCustomerColumn(): void
    {
        $schemaPath = $this->findSchemaPath();
        $xml = simplexml_load_file($schemaPath);
        $this->assertNotFalse($xml, 'pyz_contact_request.schema.xml must be valid XML.');

        $columns = $xml->xpath("//table[@name='pyz_contact_request']/column[@name='fk_customer']");
        $this->assertCount(1, $columns, 'pyz_contact_request table must have a column named fk_customer.');
        $this->assertEquals('INTEGER', (string)$columns[0]['type'], 'fk_customer column must be of type INTEGER.');
    }

    public function testSchemaHasForeignKeyToSpyCustomer(): void
    {
        $schemaPath = $this->findSchemaPath();
        $xml = simplexml_load_file($schemaPath);

        $fks = $xml->xpath("//table[@name='pyz_contact_request']/foreign-key[@foreignTable='spy_customer']");
        $this->assertCount(1, $fks, 'pyz_contact_request table must have a foreign key referencing spy_customer.');

        $references = $fks[0]->xpath("reference[@local='fk_customer'][@foreign='id_customer']");
        $this->assertCount(1, $references, 'Foreign key must map fk_customer to id_customer.');
    }

    // --- Part 2: Transfer XML ---

    public function testContactRequestTransferHasFkCustomerProperty(): void
    {
        $transferPath = $this->findTransferPath();
        $xml = simplexml_load_file($transferPath);
        $xml->registerXPathNamespace('t', 'spryker:transfer-01');

        $props = $xml->xpath("//t:transfer[@name='Message']/t:property[@name='fkCustomer']");
        $this->assertCount(1, $props, 'Message transfer must have a fkCustomer property.');
        $this->assertEquals('int', (string)$props[0]['type'], 'fkCustomer must be of type int.');
    }

    public function testContactRequestCriteriaTransferHasFkCustomerProperty(): void
    {
        $transferPath = $this->findTransferPath();
        $xml = simplexml_load_file($transferPath);
        $xml->registerXPathNamespace('t', 'spryker:transfer-01');

        $props = $xml->xpath("//t:transfer[@name='MessageCriteria']/t:property[@name='fkCustomer']");
        $this->assertCount(1, $props, 'MessageCriteria transfer must have a fkCustomer property.');
        $this->assertEquals('int', (string)$props[0]['type'], 'fkCustomer must be of type int.');
    }

    public function testContactRequestCollectionTransferExists(): void
    {
        $transferPath = $this->findTransferPath();
        $xml = simplexml_load_file($transferPath);
        $xml->registerXPathNamespace('t', 'spryker:transfer-01');

        $transfers = $xml->xpath("//t:transfer[@name='MessageCollection']");
        $this->assertCount(1, $transfers, 'A MessageCollection transfer must be defined.');

        $props = $xml->xpath("//t:transfer[@name='MessageCollection']/t:property[@name='messages']");
        $this->assertCount(1, $props, 'MessageCollection must have a messages property.');
        $this->assertEquals('Message[]', (string)$props[0]['type'], 'messages property must be of type Message[].');
    }

    // --- Part 3: GatewayController ---

    public function testGatewayControllerHasCreateMessageAction(): void
    {
        $class = 'SprykerAcademy\Zed\ContactRequest\Communication\Controller\GatewayController';
        $this->assertTrue(class_exists($class), 'GatewayController must exist.');
        $this->assertTrue(
            method_exists($class, 'createMessageAction'),
            'GatewayController must have a createMessageAction() method.',
        );
    }

    public function testGatewayControllerHasGetMessagesByCustomerAction(): void
    {
        $class = 'SprykerAcademy\Zed\ContactRequest\Communication\Controller\GatewayController';
        $this->assertTrue(class_exists($class), 'GatewayController must exist.');
        $this->assertTrue(
            method_exists($class, 'getMessagesByCustomerAction'),
            'GatewayController must have a getMessagesByCustomerAction() method.',
        );
    }

    // --- Part 4: Client/Stub ---

    public function testStubHasCreateMessageMethod(): void
    {
        $class = 'SprykerAcademy\Client\ContactRequest\Stub\ContactRequestStub';
        $this->assertTrue(class_exists($class), 'ContactRequestStub must exist.');
        $this->assertTrue(
            method_exists($class, 'createMessage'),
            'ContactRequestStub must have a createContactRequest() method.',
        );
    }

    public function testStubHasGetMessagesByCustomerMethod(): void
    {
        $class = 'SprykerAcademy\Client\ContactRequest\Stub\ContactRequestStub';
        $this->assertTrue(class_exists($class), 'ContactRequestStub must exist.');
        $this->assertTrue(
            method_exists($class, 'getMessagesByCustomer'),
            'ContactRequestStub must have a getContactRequestsByCustomer() method.',
        );
    }

    public function testClientHasCreateMessageMethod(): void
    {
        $class = 'SprykerAcademy\Client\ContactRequest\ContactRequestClient';
        $this->assertTrue(class_exists($class), 'ContactRequestClient must exist.');
        $this->assertTrue(
            method_exists($class, 'createMessage'),
            'ContactRequestClient must have a createContactRequest() method.',
        );
    }

    public function testClientHasGetMessagesByCustomerMethod(): void
    {
        $class = 'SprykerAcademy\Client\ContactRequest\ContactRequestClient';
        $this->assertTrue(class_exists($class), 'ContactRequestClient must exist.');
        $this->assertTrue(
            method_exists($class, 'getMessagesByCustomer'),
            'ContactRequestClient must have a getContactRequestsByCustomer() method.',
        );
    }

    // --- Part 5: CustomerPage Extension ---

    public function testCustomerPageDependencyProviderExists(): void
    {
        $class = 'SprykerAcademy\Yves\CustomerPage\CustomerPageDependencyProvider';
        $this->assertTrue(class_exists($class), 'CustomerPageDependencyProvider must exist in SprykerAcademy namespace.');

        $parent = 'SprykerShop\Yves\CustomerPage\CustomerPageDependencyProvider';
        if (class_exists($parent)) {
            $reflection = new \ReflectionClass($class);
            $this->assertTrue(
                $reflection->isSubclassOf($parent),
                'CustomerPageDependencyProvider must extend SprykerShop\Yves\CustomerPage\CustomerPageDependencyProvider.',
            );
        }
    }

    public function testCustomerPageFactoryExists(): void
    {
        $class = 'SprykerAcademy\Yves\CustomerPage\CustomerPageFactory';
        $this->assertTrue(class_exists($class), 'CustomerPageFactory must exist in SprykerAcademy namespace.');
        $this->assertTrue(
            method_exists($class, 'getContactRequestClient'),
            'CustomerPageFactory must have a getContactRequestClient() method.',
        );
        $this->assertTrue(
            method_exists($class, 'createContactRequestForm'),
            'CustomerPageFactory must have a createContactRequestForm() method.',
        );
    }

    public function testContactRequestControllerExists(): void
    {
        $class = 'SprykerAcademy\Yves\CustomerPage\Controller\ContactRequestController';
        $this->assertTrue(class_exists($class), 'ContactRequestController must exist in CustomerPage module.');
        $this->assertTrue(
            method_exists($class, 'listAction'),
            'ContactRequestController must have a listAction() method.',
        );
    }

    public function testContactRequestFormExists(): void
    {
        $class = 'SprykerAcademy\Yves\CustomerPage\Form\ContactRequestForm';
        $this->assertTrue(class_exists($class), 'ContactRequestForm must exist.');
        $this->assertTrue(
            method_exists($class, 'buildForm'),
            'ContactRequestForm must have a buildForm() method.',
        );
    }

    public function testRouteProviderPluginExists(): void
    {
        $class = 'SprykerAcademy\Yves\CustomerPage\Plugin\Router\CustomerPageRouteProviderPlugin';
        $this->assertTrue(class_exists($class), 'CustomerPageRouteProviderPlugin must exist in SprykerAcademy namespace.');
        $this->assertTrue(
            method_exists($class, 'addRoutes'),
            'CustomerPageRouteProviderPlugin must have an addRoutes() method.',
        );
    }

    // --- Part 6: Repository ---

    public function testRepositoryHasFindMessagesByCustomerMethod(): void
    {
        $class = 'SprykerAcademy\Zed\ContactRequest\Persistence\ContactRequestRepository';
        $this->assertTrue(class_exists($class), 'ContactRequestRepository must exist.');
        $this->assertTrue(
            method_exists($class, 'findMessagesByCustomer'),
            'ContactRequestRepository must have a findContactRequestsByCustomer() method.',
        );
    }

    public function testFacadeHasFindMessagesByCustomerMethod(): void
    {
        $class = 'SprykerAcademy\Zed\ContactRequest\Business\ContactRequestFacade';
        $this->assertTrue(class_exists($class), 'ContactRequestFacade must exist.');
        $this->assertTrue(
            method_exists($class, 'findMessagesByCustomer'),
            'ContactRequestFacade must have a findContactRequestsByCustomer() method.',
        );
    }

    // --- Part 7: Stub Gateway Path Tests ---

    public function testStubCreateMessageCallsCorrectGatewayPath(): void
    {
        $contactRequestTransfer = new ContactRequestTransfer();
        $contactRequestTransfer->setMessage('Test message');
        $contactRequestTransfer->setFkCustomer(1);

        $expectedResponse = new ContactRequestTransfer();

        $zedRequestClientMock = $this->createMock(ZedRequestClientInterface::class);
        $zedRequestClientMock->expects($this->once())
            ->method('call')
            ->with(
                '/contact-request/gateway/create-contact-request',
                $contactRequestTransfer,
            )
            ->willReturn($expectedResponse);

        $stub = new ContactRequestStub($zedRequestClientMock);
        $result = $stub->createContactRequest($contactRequestTransfer);

        $this->assertInstanceOf(
            ContactRequestTransfer::class,
            $result,
            'createContactRequest() must return a ContactRequestTransfer.',
        );
    }

    public function testStubGetMessagesByCustomerCallsCorrectGatewayPath(): void
    {
        $contactRequestCriteria = new ContactRequestCriteriaTransfer();
        $contactRequestCriteria->setFkCustomer(1);

        $expectedResponse = new ContactRequestCollectionTransfer();

        $zedRequestClientMock = $this->createMock(ZedRequestClientInterface::class);
        $zedRequestClientMock->expects($this->once())
            ->method('call')
            ->with(
                '/contact-request/gateway/get-contact-requests-by-customer',
                $contactRequestCriteria,
            )
            ->willReturn($expectedResponse);

        $stub = new ContactRequestStub($zedRequestClientMock);
        $result = $stub->getContactRequestsByCustomer($contactRequestCriteria);

        $this->assertInstanceOf(
            ContactRequestCollectionTransfer::class,
            $result,
            'getContactRequestsByCustomer() must return a ContactRequestCollectionTransfer.',
        );
    }

    // --- Part 8: Schema Timestampable ---

    public function testSchemaHasTimestampableBehavior(): void
    {
        $schemaPath = $this->findSchemaPath();
        $xml = simplexml_load_file($schemaPath);

        $behaviors = $xml->xpath("//table[@name='pyz_contact_request']/behavior[@name='timestampable']");
        $this->assertCount(1, $behaviors, 'pyz_contact_request table must have the timestampable behavior.');
    }

    // --- Part 9: Transfer createdAt ---

    public function testContactRequestTransferHasCreatedAtProperty(): void
    {
        $transferPath = $this->findTransferPath();
        $xml = simplexml_load_file($transferPath);
        $xml->registerXPathNamespace('t', 'spryker:transfer-01');

        $props = $xml->xpath("//t:transfer[@name='Message']/t:property[@name='createdAt']");
        $this->assertCount(1, $props, 'Message transfer must have a createdAt property.');
        $this->assertEquals('string', (string)$props[0]['type'], 'createdAt must be of type string.');
    }

    // --- Part 10: Delete Feature ---

    public function testDeleterClassExists(): void
    {
        $this->assertTrue(
            class_exists(ContactRequestDeleter::class),
            'ContactRequestDeleter class must exist in Business/Deleter/.',
        );
        $this->assertTrue(
            method_exists(ContactRequestDeleter::class, 'delete'),
            'ContactRequestDeleter must have a delete() method.',
        );
    }

    public function testDeleterDelegatesToEntityManager(): void
    {
        $entityManagerMock = $this->createMock(ContactRequestEntityManagerInterface::class);
        $entityManagerMock->expects($this->once())
            ->method('deleteMessage')
            ->with(42)
            ->willReturn(true);

        $deleter = new ContactRequestDeleter($entityManagerMock);
        $result = $deleter->delete(42);

        $this->assertTrue($result, 'ContactRequestDeleter::delete() must return true when entity manager succeeds.');
    }

    public function testFacadeHasDeleteMessageMethod(): void
    {
        $class = 'SprykerAcademy\Zed\ContactRequest\Business\ContactRequestFacade';
        $this->assertTrue(method_exists($class, 'deleteMessage'), 'ContactRequestFacade must have a deleteContactRequest() method.');
    }

    public function testGatewayControllerHasDeleteMessageAction(): void
    {
        $class = 'SprykerAcademy\Zed\ContactRequest\Communication\Controller\GatewayController';
        $this->assertTrue(
            method_exists($class, 'deleteMessageAction'),
            'GatewayController must have a deleteMessageAction() method.',
        );
    }

    public function testStubDeleteMessageCallsCorrectGatewayPath(): void
    {
        $contactRequestCriteria = new ContactRequestCriteriaTransfer();
        $contactRequestCriteria->setIdContactRequest(42);

        $expectedResponse = new ContactRequestResponseTransfer();
        $expectedResponse->setIsSuccessful(true);

        $zedRequestClientMock = $this->createMock(ZedRequestClientInterface::class);
        $zedRequestClientMock->expects($this->once())
            ->method('call')
            ->with(
                '/contact-request/gateway/delete-contact-request',
                $contactRequestCriteria,
            )
            ->willReturn($expectedResponse);

        $stub = new ContactRequestStub($zedRequestClientMock);
        $result = $stub->deleteContactRequest($contactRequestCriteria);

        $this->assertInstanceOf(
            ContactRequestResponseTransfer::class,
            $result,
            'deleteContactRequest() must return a ContactRequestResponseTransfer.',
        );
        $this->assertTrue($result->getIsSuccessful());
    }

    public function testClientHasDeleteMessageMethod(): void
    {
        $class = 'SprykerAcademy\Client\ContactRequest\ContactRequestClient';
        $this->assertTrue(
            method_exists($class, 'deleteMessage'),
            'ContactRequestClient must have a deleteContactRequest() method.',
        );
    }

    public function testContactRequestControllerHasDeleteAction(): void
    {
        $class = 'SprykerAcademy\Yves\CustomerPage\Controller\ContactRequestController';
        $this->assertTrue(
            method_exists($class, 'deleteAction'),
            'ContactRequestController must have a deleteAction() method.',
        );
    }

    public function testWriterDoesNotHaveDeleteMethod(): void
    {
        $class = 'SprykerAcademy\Zed\ContactRequest\Business\Writer\ContactRequestWriter';
        $this->assertFalse(
            method_exists($class, 'delete'),
            'ContactRequestWriter must NOT have a delete() method (SOLID: use ContactRequestDeleter instead).',
        );
    }

    // --- Helpers ---

    private function findSchemaPath(): string
    {
        $paths = [
            __DIR__ . '/../../../../src/SprykerAcademy/Zed/ContactRequest/Persistence/Propel/Schema/pyz_contact_request.schema.xml',
            getcwd() . '/src/SprykerAcademy/Zed/ContactRequest/Persistence/Propel/Schema/pyz_contact_request.schema.xml',
        ];

        foreach ($paths as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }

        $this->fail('Could not find pyz_contact_request.schema.xml');
    }

    private function findTransferPath(): string
    {
        $paths = [
            __DIR__ . '/../../../../src/SprykerAcademy/Shared/ContactRequest/Transfer/helloworld.transfer.xml',
            getcwd() . '/src/SprykerAcademy/Shared/ContactRequest/Transfer/helloworld.transfer.xml',
        ];

        foreach ($paths as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }

        $this->fail('Could not find helloworld.transfer.xml');
    }
}
