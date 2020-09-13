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
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
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
            new \Depense\Tests\Unit\Module\Core\Action\Fixtures\DummyHandler(),
            new \Depense\Tests\Unit\Module\Core\Action\Fixtures\DummyExceptionHandler()
        ];

        $actions = [
            \Depense\Tests\Unit\Module\Core\Action\Fixtures\Dummy::class,
            \Depense\Tests\Unit\Module\Core\Action\Fixtures\DummyException::class
        ];

        foreach ($handlers as $handler) {
            $this->registry->addHandler($handler);
        }

        foreach ($actions as $action) {
            $this->registry->addAction($action);
        }
    }

    public function testPerformTransactionCommit(): void
    {
        /** @var MockObject|EntityManagerInterface $entityManager */
        $entityManager = $this->getMockBuilder('Doctrine\ORM\EntityManagerInterface')->getMock();

        $performer = new ActionPerformer($this->registry, $entityManager);

        $entityManager->expects($this->once())
            ->method('beginTransaction');

        $entityManager->expects($this->once())
            ->method('flush');

        $entityManager->expects($this->once())
            ->method('commit');

        $result = $performer->perform(
            new \Depense\Tests\Unit\Module\Core\Action\Fixtures\Dummy('some data')
        );

        $this->assertSame('some data', $result);
    }

    public function testPerformTransactionRollback(): void
    {
        /** @var MockObject|EntityManagerInterface $entityManager */
        $entityManager = $this->getMockBuilder('Doctrine\ORM\EntityManagerInterface')->getMock();

        $performer = new ActionPerformer($this->registry, $entityManager);

        $entityManager->expects($this->once())
            ->method('beginTransaction');

        $entityManager->expects($this->once())
            ->method('rollback');

        $this->expectException(\Exception::class);

        $performer->perform(
            new \Depense\Tests\Unit\Module\Core\Action\Fixtures\DummyException()
        );
    }
}
