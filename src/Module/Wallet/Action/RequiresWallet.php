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

namespace Depense\Module\Wallet\Action;

use Depense\Module\Wallet\Model\WalletInterface;

trait RequiresWallet
{
    protected WalletInterface $wallet;

    public function __construct(WalletInterface $wallet)
    {
        $this->wallet = $wallet;
    }

    public function getWallet(): WalletInterface
    {
        return $this->wallet;
    }
}
