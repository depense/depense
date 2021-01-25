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

namespace Depense\Module\User\Model;

use Depense\Module\Resource\Model\TimestampableTrait;
use Depense\Module\Wallet\Model\WalletInterface;

class UserPreference implements UserPreferenceInterface
{
    use TimestampableTrait;

    protected ?int $id = null;

    protected ?UserInterface $user = null;

    protected ?WalletInterface $activeWallet = null;

    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->id;
    }

    public function getUser(): ?UserInterface
    {
        return $this->user;
    }

    public function setUser(?UserInterface $user): void
    {
        $this->user = $user;
    }

    public function getActiveWallet(): ?WalletInterface
    {
        return $this->activeWallet;
    }

    public function setActiveWallet(?WalletInterface $wallet): void
    {
        $this->activeWallet = $wallet;
    }
}
