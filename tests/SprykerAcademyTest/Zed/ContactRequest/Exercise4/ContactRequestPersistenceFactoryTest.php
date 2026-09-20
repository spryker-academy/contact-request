<?php

declare(strict_types=1);

namespace SprykerAcademyTest\Zed\ContactRequest\Exercise4;

use Codeception\Test\Unit;
use ReflectionMethod;
use SprykerAcademy\Zed\ContactRequest\Persistence\ContactRequestPersistenceFactory;

/**
 * Exercise 4, step 1.2: the Persistence Factory.
 *
 * createContactRequestQuery() has to hand back a Propel query object, built with
 * the static create() every generated query class carries.
 *
 * The method is read rather than called: PyzContactRequestQuery::create() needs
 * Propel's database map, which a plain unit test has not loaded.
 *
 * Run: vendor/bin/codecept run -c tests/SprykerAcademyTest/Zed/ContactRequest/ Exercise4
 */
class ContactRequestPersistenceFactoryTest extends Unit
{
    private function readCreateContactRequestQuery(): string
    {
        $method = new ReflectionMethod(ContactRequestPersistenceFactory::class, 'createContactRequestQuery');
        $lines = (array)file((string)$method->getFileName());

        return implode('', array_slice($lines, $method->getStartLine() - 1, $method->getEndLine() - $method->getStartLine() + 1));
    }

    public function testCreateContactRequestQueryReturnsAQueryBuiltWithCreate(): void
    {
        $this->assertMatchesRegularExpression(
            '/return\s+PyzContactRequestQuery::create\(\)\s*;/',
            $this->readCreateContactRequestQuery(),
            'createContactRequestQuery() must return PyzContactRequestQuery::create(). '
            . 'Every generated Propel query class has that static factory method.',
        );
    }

    public function testCreateContactRequestQueryDoesNotInstantiateTheQueryDirectly(): void
    {
        $this->assertDoesNotMatchRegularExpression(
            '/new\s+PyzContactRequestQuery/',
            $this->readCreateContactRequestQuery(),
            'Use PyzContactRequestQuery::create(), never new PyzContactRequestQuery(). '
            . '::create() is what lets a project override the generated query class.',
        );
    }

    public function testCreateContactRequestMapperReturnsAMapper(): void
    {
        // This one is provided by the skeleton - it is here as the shape to copy.
        $this->assertInstanceOf(
            \SprykerAcademy\Zed\ContactRequest\Persistence\Mapper\ContactRequestMapper::class,
            (new ContactRequestPersistenceFactory())->createContactRequestMapper(),
            'createContactRequestMapper() must return a ContactRequestMapper.',
        );
    }
}
