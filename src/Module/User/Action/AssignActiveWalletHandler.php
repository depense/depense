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

namespace Depense\Module\User\Action;

use Depense\Module\Core\Action\HandlerInterface;
use Depense\Module\User\Context\UserPreferenceContext;

class AssignActiveWalletHandler implements HandlerInterface
{
    private UserPreferenceContext $preferenceContext;

    public function __construct(UserPreferenceContext $preferenceContext)
    {
        $this->preferenceContext = $preferenceContext;
    }

    public function __invoke(AssignActiveWallet $message): void
    {
        $wallet = $message->getWallet();
        $preference = $this->preferenceContext->getUserPreference();

        if ($this->preferenceContext->getActiveWallet() !== $wallet) {
            $preference->setActiveWallet($message->getWallet());
        }
    }
}
