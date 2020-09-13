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

namespace Depense\Tests\Unit\Module\User\Provider;

use Depense\Module\User\Manager\UserManagerInterface;
use Depense\Module\User\Provider\UserEmailProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class UserEmailProviderTest extends TestCase
{
    /**
     * @var MockObject|UserManagerInterface
     */
    private MockObject $userManager;

    private UserEmailProvider $userEmailProvider;

    protected function setUp(): void
    {
        $this->userManager = $this->getMockBuilder('Depense\Module\User\Manager\UserManagerInterface')->getMock();
        $this->userEmailProvider = new UserEmailProvider($this->userManager);
    }

    public function testLoadUserByValidUsername(): void
    {
        $user = $this->getMockBuilder('Depense\Module\User\Model\UserInterface')->getMock();

        $this->userManager->expects($this->once())
            ->method('findUserByEmail')
            ->with('foobar')
            ->willReturn($user);

        $this->assertSame($user, $this->userEmailProvider->loadUserByUsername('foobar'));
    }

    public function testLoadUserByInvalidUsername(): void
    {
        $user = $this->getMockBuilder('Depense\Module\User\Model\UserInterface')->getMock();

        $this->userManager->expects($this->once())
            ->method('findUserByEmail')
            ->with('foobar')
            ->willReturn(null);

        $this->expectException(UsernameNotFoundException::class);

        $this->assertSame($user, $this->userEmailProvider->loadUserByUsername('foobar'));
    }

    public function testRefreshUser(): void
    {
        $user = $this->getMockBuilder('Depense\Module\User\Model\User')
            ->setMethods(['getId'])
            ->getMock();

        $user->expects($this->once())
            ->method('getId')
            ->will($this->returnValue(123));

        $refreshedUser = $this->getMockBuilder('Depense\Module\User\Model\UserInterface')->getMock();
        $this->userManager->expects($this->once())
            ->method('findUserById')
            ->with(123)
            ->willReturn($refreshedUser);

        $this->assertSame($refreshedUser, $this->userEmailProvider->refreshUser($user));
    }

    public function testRefreshDeleted(): void
    {
        $user = $this->getMockBuilder('Depense\Module\User\Model\User')->getMock();

        $this->userManager->expects($this->once())
            ->method('findUserById')
            ->willReturn(null);

        $this->expectException(UsernameNotFoundException::class);

        $this->userEmailProvider->refreshUser($user);
    }
}
