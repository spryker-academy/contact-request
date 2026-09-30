<?php

/**
 * This file is part of the Spryker Academy training material.
 */

declare(strict_types = 1);

namespace SprykerAcademy\Zed\ZedNavigation\Business\Strategy;

use Laminas\Config\Config;
use Spryker\Zed\ZedNavigation\Business\Strategy\BreadcrumbNavigationMergeStrategy;

/**
 * Training infrastructure - not part of any exercise.
 *
 * Breadcrumb merge, plus every top-level entry whose bundle is a SprykerAcademy module
 * (src/SprykerAcademy/Zed/SupplierGui -> "supplier-gui") and that the root navigation does not
 * define itself.
 */
class AcademyNavigationMergeStrategy extends BreadcrumbNavigationMergeStrategy
{
    public function mergeNavigation(Config $navigationDefinition, Config $rootDefinition, Config $coreNavigationDefinition): array
    {
        $navigation = parent::mergeNavigation($navigationDefinition, $rootDefinition, $coreNavigationDefinition);
        $academyBundles = $this->getAcademyBundles();

        foreach ($coreNavigationDefinition->toArray() as $name => $element) {
            if (isset($navigation[$name]) || !is_array($element)) {
                continue;
            }

            if (isset($academyBundles[$this->findBundle($element)])) {
                $navigation[$name] = $element;
            }
        }

        return $navigation;
    }

    /**
     * @return array<string, true>
     */
    protected function getAcademyBundles(): array
    {
        $bundles = [];

        foreach (glob($this->getAcademyZedDirectory() . '/*', GLOB_ONLYDIR) ?: [] as $moduleDirectory) {
            $bundle = strtolower((string)preg_replace('/(?<!^)[A-Z]/', '-$0', basename($moduleDirectory)));
            $bundles[$bundle] = true;
        }

        return $bundles;
    }

    /**
     * No constructor argument: every class under src/SprykerAcademy/Zed is registered in the Zed
     * service container, and a scalar argument there cannot be autowired.
     */
    protected function getAcademyZedDirectory(): string
    {
        return APPLICATION_SOURCE_DIR . '/SprykerAcademy/Zed';
    }

    /**
     * A top-level entry names its bundle itself, or - as a menu group - through its first page.
     */
    protected function findBundle(array $element): string
    {
        if (isset($element[static::BUNDLE])) {
            return (string)$element[static::BUNDLE];
        }

        foreach ($element[static::PAGES] ?? [] as $page) {
            if (is_array($page) && isset($page[static::BUNDLE])) {
                return (string)$page[static::BUNDLE];
            }
        }

        return '';
    }
}
