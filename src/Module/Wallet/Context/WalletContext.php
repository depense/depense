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

namespace Depense\Module\Wallet\Context;

use Depense\Module\Account\Context\AccountContext;
use Depense\Module\Wallet\Model\WalletInterface;
use Depense\Module\Wallet\Repository\WalletRepository;

class WalletContext
{
    private AccountContext $accountContext;
    private WalletRepository $walletRepository;

    public function __construct(AccountContext $accountContext, WalletRepository $walletRepository)
    {
        $this->accountContext = $accountContext;
        $this->walletRepository = $walletRepository;
    }

    /**
     * @return WalletInterface[]
     */
    public function getWallets(): array
    {
        if (!isset($this->wallets)) {
            $this->wallets = $this->walletRepository->findByAccount(
                $this->accountContext->getAccount()
            );
        }

        return $this->wallets;
    }
}
