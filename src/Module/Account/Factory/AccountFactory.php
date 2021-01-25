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

namespace Depense\Module\Account\Factory;

use Depense\Module\Account\Model\Account;
use Depense\Module\Account\Model\AccountInterface;
use Depense\Module\User\Model\UserInterface;

class AccountFactory
{
    /**
     * Used to simplify tests.
     *
     * @param UserInterface $user
     *
     * @return AccountInterface
     */
    public function createForUser(UserInterface $user): AccountInterface
    {
        $account = new Account();
        $account->setUser($user);

        return $account;
    }
}
