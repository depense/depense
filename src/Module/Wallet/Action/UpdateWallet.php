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

use Depense\Module\Core\Action\ActionInterface;
use Depense\Module\Wallet\Model\WalletInterface;

class UpdateWallet implements ActionInterface
{
    use RequiresWallet {
        RequiresWallet::__construct as private __wConstruct;
    }

    protected int $oldBalance;

    public function __construct(int $oldBalance, WalletInterface $wallet)
    {
        $this->__wConstruct($wallet);

        $this->oldBalance = $oldBalance;
    }

    public function getOldBalance(): int
    {
        return $this->oldBalance;
    }
}
