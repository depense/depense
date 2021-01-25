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

namespace Depense\Module\Core\Context;

use Depense\Module\Account\Context\AccountContext;
use Depense\Module\Account\Model\AccountInterface;
use Depense\Module\Taxonomy\Context\TaxonContext;
use Depense\Module\Taxonomy\Model\TaxonInterface;
use Depense\Module\User\Context\UserContext;
use Depense\Module\User\Context\UserPreferenceContext;
use Depense\Module\User\Model\UserInterface;
use Depense\Module\User\Model\UserPreferenceInterface;
use Depense\Module\Wallet\Context\WalletContext;
use Depense\Module\Wallet\Model\WalletInterface;

class AppContext
{
    private AccountContext $accountContext;
    private WalletContext $walletContext;
    private UserContext $userContext;
    private UserPreferenceContext $userPreferenceContext;
    private TaxonContext $taxonContext;

    public function __construct(
        AccountContext $accountContext,
        WalletContext $walletContext,
        UserContext $userContext,
        UserPreferenceContext $userPreferenceContext,
        TaxonContext $taxonContext)
    {
        $this->accountContext = $accountContext;
        $this->walletContext = $walletContext;
        $this->userContext = $userContext;
        $this->userPreferenceContext = $userPreferenceContext;
        $this->taxonContext = $taxonContext;
    }

    public function getAccount(): AccountInterface
    {
        return $this->accountContext->getAccount();
    }

    public function getActiveWallet(): ?WalletInterface
    {
        return $this->userPreferenceContext->getActiveWallet();
    }

    /**
     * @return WalletInterface[]
     */
    public function getWallets(): array
    {
        return $this->walletContext->getWallets();
    }

    public function getUser(): UserInterface
    {
        return $this->userContext->getUser();
    }

    public function getUserPreference(): UserPreferenceInterface
    {
        return $this->userPreferenceContext->getUserPreference();
    }

    /**
     * @return TaxonInterface[]
     */
    public function getTaxa(): array
    {
        return $this->taxonContext->getTaxa();
    }
}
