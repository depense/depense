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

namespace Depense\Web\Twig;

use Depense\Module\Account\Model\AccountInterface;
use Depense\Module\Core\Context\AppContext;
use Depense\Module\Taxonomy\Model\TaxonInterface;
use Depense\Module\User\Model\User;
use Depense\Module\User\Model\UserInterface;
use Depense\Module\Wallet\Model\WalletInterface;

/**
 * Exposes some Depense parameters and services as an "depense" global variable.
 *
 * Use this service only when the user
 * is authenticated.
 */
class DepenseAppVariable
{
    private AppContext $appContext;

    public function __construct(AppContext $appContext)
    {
        $this->appContext = $appContext;
    }

    public function getAccount(): AccountInterface
    {
        if (!isset($this->account)) {
            $this->account = $this->appContext->getAccount();
        }

        return $this->account;
    }

    public function getActiveWallet(): ?WalletInterface
    {
        if (!isset($this->activeWallet)) {
            $this->activeWallet = $this->appContext->getActiveWallet();
        }

        return $this->activeWallet;
    }

    /**
     * @return WalletInterface[]
     */
    public function getWallets(): array
    {
        if (!isset($this->wallets)) {
            $this->wallets = $this->appContext->getWallets();
        }

        return $this->wallets;
    }

    /**
     * @return User|UserInterface|\Symfony\Component\Security\Core\User\UserInterface
     */
    public function getUser(): UserInterface
    {
        if (!isset($this->user)) {
            $this->user = $this->appContext->getUser();
        }

        return $this->user;
    }

    /**
     * @return TaxonInterface[]
     */
    public function getTaxa(): array
    {
        if (!isset($this->taxa)) {
            $this->taxa = $this->appContext->getTaxa();
        }

        return $this->taxa;
    }
}
