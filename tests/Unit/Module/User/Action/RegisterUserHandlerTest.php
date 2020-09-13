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

namespace Depense\Tests\Unit\Module\User\Action;

use Depense\Module\User\Action\RegisterUser;
use Depense\Module\User\Action\RegisterUserAction;
use Depense\Module\User\Action\RegisterUserHandler;
use Depense\Module\User\Event\UserRegisteredEvent;
use Depense\Module\User\Manager\UserManagerInterface;
use Depense\Module\User\Model\UserInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class RegisterUserHandlerTest extends TestCase
{
    /**
     * @var MockObject|UserManagerInterface
     */
    protected MockObject $userManager;

    /**
     * @var MockObject|EventDispatcherInterface
     */
    protected MockObject $eventDispatcher;

    protected RegisterUserHandler $action;

    protected function setUp(): void
    {
        $this->userManager = $this->getMockBuilder('Depense\Module\User\Manager\UserManagerInterface')->getMock();
        $this->eventDispatcher = $this->getMockBuilder('Symfony\Contracts\EventDispatcher\EventDispatcherInterface')->getMock();

        $this->action = new RegisterUserHandler($this->userManager, $this->eventDispatcher);
    }

    public function testRegisterUser(): void
    {
        /** @var UserInterface $user */
        $user = $this->getMockBuilder('Depense\Module\User\Model\UserInterface')->getMock();

        $this->userManager->expects($this->once())
            ->method('updateUser')
            ->with($user);

        $this->eventDispatcher->expects($this->once())
            ->method('dispatch')
            ->with(new UserRegisteredEvent($user));

        $action = $this->action;

        $action(new RegisterUser($user));
    }
}
