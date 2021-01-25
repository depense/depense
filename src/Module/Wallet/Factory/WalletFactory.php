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

namespace Depense\Module\Wallet\Factory;

use Depense\Module\Account\Context\AccountContext;
use Depense\Module\Wallet\Model\Wallet;
use Depense\Module\Wallet\Model\WalletInterface;

class WalletFactory
{
    protected AccountContext $accountContext;

    public function __construct(AccountContext $accountContext)
    {
        $this->accountContext = $accountContext;
    }

    public function create(): WalletInterface
    {
        $wallet = new Wallet();
        $wallet->setAccount(
            $this->accountContext->getAccount()
        );

        return $wallet;
    }
}
