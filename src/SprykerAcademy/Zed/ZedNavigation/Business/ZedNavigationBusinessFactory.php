<?php

/**
 * This file is part of the Spryker Academy training material.
 */

declare(strict_types = 1);

namespace SprykerAcademy\Zed\ZedNavigation\Business;

use Spryker\Zed\ZedNavigation\Business\Strategy\NavigationMergeStrategyInterface;
use Spryker\Zed\ZedNavigation\Business\ZedNavigationBusinessFactory as SprykerZedNavigationBusinessFactory;
use SprykerAcademy\Zed\ZedNavigation\Business\Strategy\AcademyNavigationMergeStrategy;

/**
 * Training infrastructure - not part of any exercise.
 *
 * The shop merges navigation with the breadcrumb strategy: config/Zed/navigation.xml decides the
 * menu, and a module's Communication/navigation.xml can only add pages below an entry that is
 * already there. This factory swaps in a strategy that also appends the top-level entries of the
 * SprykerAcademy modules, so an exercise ships its menu entry with the module instead of editing
 * the project's navigation.xml.
 */
class ZedNavigationBusinessFactory extends SprykerZedNavigationBusinessFactory
{
    public function createBreadcrumbNavigationMergeStrategy(): NavigationMergeStrategyInterface
    {
        return new AcademyNavigationMergeStrategy();
    }
}
