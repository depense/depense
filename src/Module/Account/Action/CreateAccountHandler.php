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

namespace Depense\Module\Account\Action;

use Depense\Module\Account\Factory\AccountFactory;
use Depense\Module\Account\Model\Account;
use Depense\Module\Account\Model\AccountInterface;
use Depense\Module\Account\Repository\AccountRepository;
use Depense\Module\Core\Action\HandlerInterface;
use Depense\Module\User\Model\UserInterface;

class CreateAccountHandler implements HandlerInterface
{
    protected AccountFactory $accountFactory;
    protected AccountRepository $accountRepository;

    public function __construct(AccountFactory $accountFactory, AccountRepository $accountRepository)
    {
        $this->accountFactory = $accountFactory;
        $this->accountRepository = $accountRepository;
    }

    public function __invoke(CreateAccount $message): AccountInterface
    {
        $account = $this->accountFactory->createForUser($message->getUser());

        $this->accountRepository->add($account);

        return $account;
    }

    protected function createAccount(UserInterface $user): AccountInterface
    {
        $account = new Account();
        $account->setUser($user);

        return $account;
    }
}
