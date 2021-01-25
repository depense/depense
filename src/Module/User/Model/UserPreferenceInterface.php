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

use Depense\Module\Resource\Model\ResourceInterface;
use Depense\Module\Resource\Model\TimestampableInterface;
use Depense\Module\Wallet\Model\WalletInterface;

interface UserPreferenceInterface extends ResourceInterface, UserAwareInterface, TimestampableInterface
{
    public function getActiveWallet(): ?WalletInterface;

    public function setActiveWallet(?WalletInterface $wallet): void;
}
