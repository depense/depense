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

namespace Depense\Module\User\Context;

use Depense\Module\User\Model\UserPreferenceInterface;
use Depense\Module\User\Repository\UserPreferenceRepository;
use Depense\Module\Wallet\Context\WalletContext;
use Depense\Module\Wallet\Model\WalletInterface;
use Doctrine\ORM\EntityManagerInterface;

class UserPreferenceContext
{
    private UserContext $userContext;
    private WalletContext $walletContext;
    private UserPreferenceRepository $preferenceRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(
        UserContext $userContext,
        WalletContext $walletContext,
        UserPreferenceRepository $preferenceRepository,
        EntityManagerInterface $entityManager
    )
    {
        $this->userContext = $userContext;
        $this->preferenceRepository = $preferenceRepository;
        $this->walletContext = $walletContext;
        $this->entityManager = $entityManager;
    }

    public function getUserPreference(): UserPreferenceInterface
    {
        if (!isset($this->userPreference)) {
            $preference = $this->preferenceRepository->findByUser(
                $this->userContext->getUser()
            );

            if (null === $preference) {
                throw new UserPreferenceNotFoundException();
            }

            $this->userPreference = $preference;
        }

        return $this->userPreference;
    }

    public function getActiveWallet(): ?WalletInterface
    {
        if (!isset($this->activeWallet)) {
            $activeWallet = $this->getUserPreference()->getActiveWallet();

            if (null === $activeWallet) {
                return null;
            }

            // Used to avoid joining wallets table.
            $activeWalletData = $this->entityManager->getUnitOfWork()->getEntityIdentifier($activeWallet);

            foreach ($this->walletContext->getWallets() as $wallet) {
                if ($activeWalletData['id'] === $wallet->getId()) {
                    $this->activeWallet = $wallet;
                    break;
                }
            }
        }

        return $this->activeWallet;
    }
}
