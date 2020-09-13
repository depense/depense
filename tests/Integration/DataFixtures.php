<?php
/*
 * This file is part of the Depense.Net package.
 *
 * (c) Mohamed Radhi GUENNICHI <rg@mate.tn> <+216 50 711 816>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Depense\Tests\Integration;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bridge\Doctrine\DataFixtures\ContainerAwareLoader;

trait DataFixtures
{
    private ?ORMExecutor $fixtureExecutor = null;

    private ?ContainerAwareLoader $fixtureLoader = null;

    protected function loadFixtures(array $fixtureClasses): void
    {
        $symfonyLoader = static::$container->get('doctrine.fixtures.loader');
        $fixtureLoader = $this->getFixtureLoader();

        foreach ($fixtureClasses as $class) {
            $fixtureLoader->addFixture(
                $symfonyLoader->getFixture($class)
            );
        }

        $this->getFixtureExecutor()->execute(
            $fixtureLoader->getFixtures()
        );
    }

    private function getFixtureExecutor(): ORMExecutor
    {
        if (!$this->fixtureExecutor) {
            $entityManager = static::$container->get('doctrine.orm.entity_manager');
            $this->fixtureExecutor = new ORMExecutor($entityManager, new ORMPurger($entityManager));
        }

        return $this->fixtureExecutor;
    }

    private function getFixtureLoader(): ContainerAwareLoader
    {
        if (!$this->fixtureLoader) {
            $this->fixtureLoader = new ContainerAwareLoader(static::$container);
        }

        return $this->fixtureLoader;
    }
}
