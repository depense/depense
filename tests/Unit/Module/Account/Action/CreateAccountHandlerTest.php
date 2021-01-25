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

namespace Depense\Tests\Unit\Module\Account\Action;

use Depense\Module\Account\Action\CreateAccount;
use Depense\Module\Account\Action\CreateAccountHandler;
use Depense\Module\Account\Factory\AccountFactory;
use Depense\Module\Account\Repository\AccountRepository;
use Depense\Module\User\Model\UserInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CreateAccountHandlerTest extends TestCase
{
    /**
     * @var MockObject|AccountRepository
     */
    protected MockObject $accountRepository;

    /**
     * @var MockObject|AccountFactory
     */
    protected MockObject $accountFactory;

    protected CreateAccountHandler $createAccountHandler;

    protected function setUp(): void
    {
        $this->accountRepository = $this->getMockBuilder('Depense\Module\Account\Repository\AccountRepository')
            ->disableOriginalConstructor()
            ->getMock();

        $this->accountFactory = $this->getMockBuilder('Depense\Module\Account\Factory\AccountFactory')
            ->disableOriginalConstructor()
            ->getMock();

        $this->createAccountHandler = new CreateAccountHandler($this->accountFactory, $this->accountRepository);
    }

    public function testCreateAccount(): void
    {
        /** @var MockObject|UserInterface $user */
        $user = $this->getMockBuilder('Depense\Module\User\Model\UserInterface')->getMock();
        $account = $this->getMockBuilder('Depense\Module\Account\Model\AccountInterface')->getMock();

        $this->accountFactory->expects($this->once())
            ->method('createForUser')
            ->with($user)
            ->willReturn($account);

        $this->accountRepository->expects($this->once())
            ->method('add')
            ->with($account);

        $createAccountHandler = $this->createAccountHandler;

        $createAccountHandler(new CreateAccount($user));
    }
}
