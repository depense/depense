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

namespace Depense\Tests\Unit\Module\Core\Action;

use Depense\Module\Core\Action\ActionRegistry;
use Depense\Tests\Unit\Module\Core\Action\Fixtures\Dummy;
use Depense\Tests\Unit\Module\Core\Action\Fixtures\DummyHandler;
use PHPUnit\Framework\TestCase;

class ActionRegistryTest extends TestCase
{
    public function testAddHandler(): void
    {
        $registry = new ActionRegistry();
        $registry->addHandler($handler = new DummyHandler());

        $this->assertCount(1, $registry->getHandlers());

        $expectedHandlers = ['Depense\Tests\Unit\Module\Core\Action\Fixtures\DummyHandler' => $handler];

        $this->assertSame($expectedHandlers, $registry->getHandlers());
    }

    public function testAddAction(): void
    {
        $registry = new ActionRegistry();
        $registry->addAction(Dummy::class);

        $this->assertCount(1, $registry->getActions());
        $this->assertSame(['Depense\Tests\Unit\Module\Core\Action\Fixtures\Dummy' => null], $registry->getActions());
    }

    public function testMatchActionWithHandler(): void
    {
        $registry = new ActionRegistry();
        $registry->addHandler($handler = new DummyHandler());
        $registry->addAction(Dummy::class);

        $this->assertCount(1, $registry->getActions());

        $expectedActions = ['Depense\Tests\Unit\Module\Core\Action\Fixtures\Dummy' => $handler];

        $this->assertSame($expectedActions, $registry->getActions());
    }
}
