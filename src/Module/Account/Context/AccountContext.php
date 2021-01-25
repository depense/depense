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

namespace Depense\Module\Account\Context;

use Depense\Module\Account\Model\AccountInterface;
use Depense\Module\Account\Repository\AccountRepository;
use Depense\Module\User\Context\UserContext;

class AccountContext
{
    private UserContext $userContext;
    private AccountRepository $accountRepository;

    public function __construct(UserContext $userContext, AccountRepository $accountRepository)
    {
        $this->userContext = $userContext;
        $this->accountRepository = $accountRepository;
    }

    public function getAccount(): AccountInterface
    {
        if (!isset($this->account)) {
            if (null === $account = $this->accountRepository->findByUser($this->userContext->getUser())) {
                throw new AccountNotFoundException();
            }

            $this->account = $account;
        }

        return $this->account;
    }
}
