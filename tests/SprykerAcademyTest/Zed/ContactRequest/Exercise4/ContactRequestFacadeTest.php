<?php

declare(strict_types=1);

namespace SprykerAcademyTest\Zed\ContactRequest\Exercise4;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ContactRequestCriteriaTransfer;
use Generated\Shared\Transfer\ContactRequestResponseTransfer;
use Generated\Shared\Transfer\ContactRequestTransfer;
use Spryker\Service\Container\ContainerDelegator;
use SprykerAcademy\Zed\ContactRequest\Business\ContactRequestFacade;
use SprykerAcademy\Zed\ContactRequest\Business\Reader\ContactRequestReader;
use SprykerAcademy\Zed\ContactRequest\Business\Writer\ContactRequestWriter;

/**
 * Exercise 4: Module Layers - ContactRequestFacade
 *
 * Verifies that the Facade really delegates to the Writer and the Reader and
 * hands their result back. A Facade whose methods are still empty fails here.
 *
 * The test does not care HOW the Facade reaches the business models - through
 * $this->getService(ClassName::class) or through the Business Factory - so it
 * stays valid across the exercises.
 *
 * Run: vendor/bin/codecept run -c tests/SprykerAcademyTest/Zed/ContactRequest/ Exercise4
 */
class ContactRequestFacadeTest extends Unit
{
    public function testCreateContactRequestDelegatesToWriterAndReturnsItsResult(): void
    {
        $this->skipUnlessFacadeExists();

        // Arrange
        $persisted = (new ContactRequestTransfer())
            ->setIdContactRequest(42)
            ->setMessage('Hello from the Writer');

        $writerMock = $this->createMock(ContactRequestWriter::class);
        $writerMock->expects($this->once())
            ->method('create')
            ->willReturn($persisted);

        $facade = $this->createFacade(['createContactRequestWriter' => $writerMock]);

        // Act
        $result = $facade->createContactRequest(
            (new ContactRequestTransfer())->setMessage('Hello from the Writer'),
        );

        // Assert
        $this->assertSame(
            $persisted,
            $result,
            'createContactRequest() must return what the ContactRequestWriter returned. '
            . 'Delegate to the Writer instead of leaving the method empty.',
        );
    }

    public function testFindContactRequestDelegatesToReaderAndReturnsItsResult(): void
    {
        $this->skipUnlessFacadeExists();

        // Arrange
        $response = (new ContactRequestResponseTransfer())
            ->setIsSuccessful(true)
            ->setContactRequest((new ContactRequestTransfer())->setMessage('Found'));

        $readerMock = $this->createMock(ContactRequestReader::class);
        $readerMock->expects($this->once())
            ->method('findContactRequest')
            ->willReturn($response);

        $facade = $this->createFacade(['createContactRequestReader' => $readerMock]);

        // Act
        $result = $facade->findContactRequest(
            (new ContactRequestCriteriaTransfer())->setIdContactRequest(42),
        );

        // Assert
        $this->assertSame(
            $response,
            $result,
            'findContactRequest() must return what the ContactRequestReader returned. '
            . 'Delegate to the Reader instead of leaving the method empty.',
        );
    }

    /**
     * Wires the mocked business model into both routes a Facade can take:
     * the service container behind getService(), and the Business Factory.
     *
     * @param array<string, object> $servicesByFactoryMethod
     */
    private function createFacade(array $servicesByFactoryMethod): ContactRequestFacade
    {
        $facade = new ContactRequestFacade();

        foreach ($servicesByFactoryMethod as $factoryMethod => $service) {
            $this->bindService(get_parent_class($service) ?: $service::class, $service);

            $factoryClass = 'SprykerAcademy\Zed\ContactRequest\Business\ContactRequestBusinessFactory';

            if (method_exists($factoryClass, $factoryMethod)) {
                $factoryMock = $this->getMockBuilder($factoryClass)
                    ->disableOriginalConstructor()
                    ->onlyMethods([$factoryMethod])
                    ->getMock();
                $factoryMock->method($factoryMethod)->willReturn($service);
                $facade->setFactory($factoryMock);
            }
        }

        return $facade;
    }

    /**
     * ContainerDelegator::set() writes to its $services map, but get() answers from
     * $resolvedServices and never invalidates it. Without seeding that second map the
     * first test to bind an id would win for the whole run, and the next one would
     * silently assert against someone else's mock.
     */
    private function bindService(string $id, object $service): void
    {
        $container = ContainerDelegator::getInstance();
        $container->set($id, $service);

        $property = new \ReflectionProperty($container, 'resolvedServices');
        $property->setAccessible(true);
        $resolved = $property->getValue($container);
        $resolved[$id] = $service;
        $property->setValue($container, $resolved);
    }

    private function skipUnlessFacadeExists(): void
    {
        foreach ([ContactRequestFacade::class, ContactRequestWriter::class, ContactRequestReader::class] as $class) {
            if (!class_exists($class)) {
                $this->markTestSkipped($class . ' does not exist yet.');
            }
        }
    }
}
