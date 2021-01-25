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

use Depense\Module\Core\Action\HandlerInterface;
use Depense\Module\Wallet\Repository\WalletRepository;

class DeleteWalletHandler implements HandlerInterface
{
    protected WalletRepository $walletRepository;

    public function __construct(WalletRepository $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    public function __invoke(DeleteWallet $message): void
    {
        $this->walletRepository->remove(
            $message->getWallet()
        );
    }
}
