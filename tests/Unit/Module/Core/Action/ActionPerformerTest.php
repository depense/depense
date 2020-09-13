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

use Depense\Module\Core\Action\ActionPerformer;
use Depense\Module\Core\Action\ActionRegistry;
use PHPUnit\Framework\TestCase;

class ActionPerformerTest extends TestCase
{
    protected ActionRegistry $registry;

    protected function setUp(): void
    {
        $this->registry = new ActionRegistry();

        $handlers = [
            // Normally it's injected via the compiler pass
            // and passed by it's reference.
            new \Depense\Tests\Unit\Module\Core\Action\Fixtures\DummyHandler()
        ];

        $actions = [
            \Depense\Tests\Unit\Module\Core\Action\Fixtures\Dummy::class
        ];

        foreach ($handlers as $handler) {
            $this->registry->addHandler($handler);
        }

        foreach ($actions as $action) {
            $this->registry->addAction($action);
        }
    }

    public function testPerform(): void
    {
        $performer = new ActionPerformer($this->registry);

        $result = $performer->perform(
            new \Depense\Tests\Unit\Module\Core\Action\Fixtures\Dummy('some data')
        );

        $this->assertSame('some data', $result);
    }
}
