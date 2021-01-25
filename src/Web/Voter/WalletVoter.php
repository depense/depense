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

namespace Depense\Web\Voter;

use Depense\Module\Account\Context\AccountContext;
use Depense\Module\User\Model\UserInterface;
use Depense\Module\Wallet\Model\WalletInterface;
use LogicException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class WalletVoter extends Voter
{
    const SWITCH = 'switch';

    private AccountContext $accountContext;

    public function __construct(AccountContext $accountContext)
    {
        $this->accountContext = $accountContext;
    }

    /**
     * @inheritDoc
     */
    protected function supports(string $attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::SWITCH])) {
            return false;
        }

        // only vote on `Wallet` objects
        if (!$subject instanceof WalletInterface) {
            return false;
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            // the user must be logged in; if not, deny access
            return false;
        }

        /** @var WalletInterface $wallet */
        $wallet = $subject;

        switch ($attribute) {
            case self::SWITCH:
                return $this->canSwitch($wallet, $user);
        }

        throw new LogicException('This code should not be reached!');
    }

    private function canSwitch(WalletInterface $wallet, UserInterface $user): bool
    {
        return $wallet->getAccount()->getUser() === $user;
    }
}
