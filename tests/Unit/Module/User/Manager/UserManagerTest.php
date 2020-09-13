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

namespace Depense\Tests\Unit\Module\User\Manager;

use Depense\Module\User\Manager\UserManager;
use Depense\Module\User\Model\UserInterface;
use Depense\Module\User\Repository\UserRepository;
use Depense\Module\User\Util\UserCanonicalUpdater;
use Depense\Module\User\Util\UserPasswordUpdater;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UserManagerTest extends TestCase
{
    /**
     * @var MockObject|UserRepository
     */
    private MockObject $userRepository;

    /**
     * @var MockObject|UserCanonicalUpdater
     */
    private MockObject $canonicalUpdater;

    /**
     * @var MockObject|UserPasswordUpdater
     */
    private MockObject $passwordUpdater;

    private UserManager $userManager;

    protected function setUp(): void
    {
        $this->userRepository = $this->getMockBuilder('Depense\Module\User\Repository\UserRepository')
            ->disableOriginalConstructor()
            ->getMock();

        $this->canonicalUpdater = $this->getMockBuilder('Depense\Module\User\Util\UserCanonicalUpdater')
            ->disableOriginalConstructor()
            ->getMock();
        $this->passwordUpdater = $this->getMockBuilder('Depense\Module\User\Util\UserPasswordUpdater')
            ->disableOriginalConstructor()
            ->getMock();

        $this->userManager = new UserManager($this->userRepository, $this->canonicalUpdater, $this->passwordUpdater);
    }

    public function testFindUserByEmail(): void
    {
        $user = $this->getMockBuilder('Depense\Module\User\Model\UserInterface')->getMock();

        $this->canonicalUpdater->expects($this->once())
            ->method('canonicalizeEmail')
            ->with('FoObAr')
            ->willReturn('foobar');

        $this->userRepository->expects($this->once())
            ->method('findByEmailCanonical')
            ->with('foobar')
            ->willReturn($user);

        $this->assertSame($user, $this->userManager->findUserByEmail('FoObAr'));
    }

    public function testFindUserById(): void
    {
        $user = $this->getMockBuilder('Depense\Module\User\Model\UserInterface')->getMock();

        $this->userRepository->expects($this->once())
            ->method('findById')
            ->with(123)
            ->willReturn($user);

        $this->assertSame($user, $this->userManager->findUserById(123));
    }

    public function testDeleteUser(): void
    {
        /** @var UserInterface $user */
        $user = $this->getMockBuilder('Depense\Module\User\Model\UserInterface')->getMock();

        $this->userRepository->expects($this->once())
            ->method('remove')
            ->with($user);

        $this->userManager->deleteUser($user);
    }

    public function testUpdateNewUser(): void
    {
        /** @var UserInterface|MockObject $user */
        $user = $this->getMockBuilder('Depense\Module\User\Model\User')
            ->setMethods(['getId'])
            ->getMock();
        $user->expects($this->once())
            ->method('getId')
            ->willReturn(null);

        $this->canonicalUpdater->expects($this->once())
            ->method('updateCanonicalFields')
            ->with($user);

        $this->passwordUpdater->expects($this->once())
            ->method('updatePassword')
            ->with($user);

        $this->userRepository->expects($this->once())
            ->method('add')
            ->with($user);

        $this->userManager->updateUser($user);
    }

    public function testUpdateExistedUser(): void
    {
        /** @var UserInterface|MockObject $user */
        $user = $this->getMockBuilder('Depense\Module\User\Model\User')
            ->setMethods(['getId'])
            ->getMock();
        $user->expects($this->once())
            ->method('getId')
            ->willReturn(123);

        $this->canonicalUpdater->expects($this->once())
            ->method('updateCanonicalFields')
            ->with($user);

        $this->passwordUpdater->expects($this->once())
            ->method('updatePassword')
            ->with($user);

        $this->userRepository->expects($this->never())
            ->method('add');

        $this->userManager->updateUser($user);
    }
}
