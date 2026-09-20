<?php

declare(strict_types=1);

namespace SprykerAcademyTest\Zed\ContactRequest\Exercise4;

use Codeception\Test\Unit;
use SimpleXMLElement;

/**
 * Exercise 4, steps 1.1 and 2.1: the two transfers this exercise adds.
 *
 * ContactRequestCriteria carries the lookup parameters, ContactRequestResponse
 * wraps the result with a success flag. Both are strict, like every transfer in
 * this module.
 *
 * Run: vendor/bin/codecept run -c tests/SprykerAcademyTest/Zed/ContactRequest/ Exercise4
 */
class ContactRequestTransferDefinitionTest extends Unit
{
    private const string TRANSFER_XML_RELATIVE_PATH =
        'src/SprykerAcademy/Shared/ContactRequest/Transfer/contact_request.transfer.xml';

    private function loadTransferXml(): SimpleXMLElement
    {
        foreach ([dirname(__DIR__, 5), getcwd()] as $base) {
            $candidate = $base . '/' . self::TRANSFER_XML_RELATIVE_PATH;

            if (file_exists($candidate)) {
                $xml = simplexml_load_file($candidate);
                $this->assertNotFalse($xml, 'Failed to parse contact_request.transfer.xml.');
                $xml->registerXPathNamespace('t', 'spryker:transfer-01');

                return $xml;
            }
        }

        $this->fail('Cannot find contact_request.transfer.xml. Expected at: ' . self::TRANSFER_XML_RELATIVE_PATH);
    }

    /**
     * @return array<\SimpleXMLElement>
     */
    private function find(string $xpath): array
    {
        $xml = $this->loadTransferXml();
        $namespaced = $xml->xpath('//t:' . str_replace('/', '/t:', $xpath));

        // Some students drop the xmlns; fall back to the plain names then.
        return $namespaced ?: ($xml->xpath('//' . $xpath) ?: []);
    }

    private function assertHasProperty(string $transfer, string $property, string $type): void
    {
        $properties = $this->find(sprintf('transfer[@name="%s"]/property[@name="%s"]', $transfer, $property));

        $this->assertNotEmpty(
            $properties,
            sprintf('The %s transfer must have a property named "%s".', $transfer, $property),
        );
        $this->assertSame(
            $type,
            (string)$properties[0]['type'],
            sprintf('Property "%s" of %s must be of type "%s".', $property, $transfer, $type),
        );
    }

    private function assertIsStrict(string $transfer): void
    {
        $transfers = $this->find(sprintf('transfer[@name="%s"]', $transfer));

        $this->assertNotEmpty($transfers, sprintf('A <transfer name="%s"> definition is missing.', $transfer));
        $this->assertSame(
            'true',
            (string)$transfers[0]['strict'],
            sprintf(
                'The %s transfer must carry strict="true", so its accessors get native PHP types.',
                $transfer,
            ),
        );
    }

    public function testContactRequestCriteriaTransferIsDefined(): void
    {
        $this->assertNotEmpty(
            $this->find('transfer[@name="ContactRequestCriteria"]'),
            'A <transfer name="ContactRequestCriteria"> definition is missing (step 1.1).',
        );
    }

    public function testContactRequestCriteriaHasIdContactRequestProperty(): void
    {
        $this->assertHasProperty('ContactRequestCriteria', 'idContactRequest', 'int');
    }

    public function testContactRequestCriteriaHasMessageProperty(): void
    {
        $this->assertHasProperty('ContactRequestCriteria', 'message', 'string');
    }

    public function testContactRequestCriteriaIsStrict(): void
    {
        $this->assertIsStrict('ContactRequestCriteria');
    }

    public function testContactRequestResponseTransferIsDefined(): void
    {
        $this->assertNotEmpty(
            $this->find('transfer[@name="ContactRequestResponse"]'),
            'A <transfer name="ContactRequestResponse"> definition is missing (step 2.1).',
        );
    }

    public function testContactRequestResponseHasContactRequestProperty(): void
    {
        $this->assertHasProperty('ContactRequestResponse', 'contactRequest', 'ContactRequest');
    }

    public function testContactRequestResponseHasIsSuccessfulProperty(): void
    {
        $this->assertHasProperty('ContactRequestResponse', 'isSuccessful', 'bool');
    }

    public function testContactRequestResponseIsStrict(): void
    {
        $this->assertIsStrict('ContactRequestResponse');
    }
}
