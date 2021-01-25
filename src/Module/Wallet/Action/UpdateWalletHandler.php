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

class UpdateWalletHandler implements HandlerInterface
{
    public function __invoke(UpdateWallet $message): void
    {
        // todo
        // compare the old balance with the new one
        // if it's smaller then the current one
        // then create a new debit transaction
        // if it's bigger then create a new credit transaction
        // else do nothing.
    }
}
