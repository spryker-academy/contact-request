<?php

declare(strict_types=1);

namespace SprykerAcademyTest\Zed\ContactRequest\Exercise4;

use Codeception\Test\Unit;

/**
 * Exercise 4, step 3.2: the Back Office template.
 *
 * add.twig has to print the message of the transfer the controller passed,
 * reached with dot notation, instead of the placeholder the skeleton ships.
 *
 * Run: vendor/bin/codecept run -c tests/SprykerAcademyTest/Zed/ContactRequest/ Exercise4
 */
class AddTemplateTest extends Unit
{
    private const string TEMPLATE_RELATIVE_PATH =
        'src/SprykerAcademy/Zed/ContactRequest/Presentation/Index/add.twig';

    private const string PLACEHOLDER = 'show-contact-request-message-here';

    private function loadTemplate(): string
    {
        // From this file up to the project root, then from the working directory.
        foreach ([dirname(__DIR__, 5), getcwd()] as $base) {
            $candidate = $base . '/' . self::TEMPLATE_RELATIVE_PATH;

            if (file_exists($candidate)) {
                return (string)file_get_contents($candidate);
            }
        }

        $this->fail('Cannot find the template. Expected at: ' . self::TEMPLATE_RELATIVE_PATH);
    }

    public function testAddTemplatePrintsTheContactRequestMessage(): void
    {
        $template = $this->loadTemplate();

        $this->assertMatchesRegularExpression(
            '/\{\{\s*contactRequest\.message\s*\}\}/',
            $template,
            'add.twig must print the message with dot notation: {{ contactRequest.message }}. '
            . 'The controller passes the transfer under the key "contactRequest".',
        );
    }

    public function testAddTemplateNoLongerContainsThePlaceholder(): void
    {
        $this->assertStringNotContainsString(
            self::PLACEHOLDER,
            $this->loadTemplate(),
            'add.twig still contains the placeholder "' . self::PLACEHOLDER . '". Replace it.',
        );
    }

    public function testAddTemplateDoesNotReachForThePropertyThroughAGetter(): void
    {
        $template = $this->loadTemplate();

        $this->assertDoesNotMatchRegularExpression(
            '/contactRequest\.getMessage\(\)/',
            $template,
            'Use dot notation (contactRequest.message), not contactRequest.getMessage(). '
            . 'Twig resolves the getter for you.',
        );
    }
}
