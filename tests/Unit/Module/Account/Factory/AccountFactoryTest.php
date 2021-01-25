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

namespace Depense\Tests\Unit\Module\Account\Factory;

use Depense\Module\Account\Factory\AccountFactory;
use Depense\Module\Account\Model\AccountInterface;
use Depense\Module\User\Model\User;
use PHPUnit\Framework\TestCase;

class AccountFactoryTest extends TestCase
{
    protected AccountFactory $accountFactory;

    protected function setUp(): void
    {
        $this->accountFactory = new AccountFactory();
    }

    public function testCreateForUser(): void
    {
        $user = new User();

        $account = $this->accountFactory->createForUser($user);

        $this->assertInstanceOf(AccountInterface::class, $account);
        $this->assertSame($user, $account->getUser());
    }
}
