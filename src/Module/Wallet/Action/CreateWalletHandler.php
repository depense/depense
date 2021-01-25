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

use Depense\Module\Core\Action\ActionPerformer;
use Depense\Module\Core\Action\HandlerInterface;
use Depense\Module\User\Action\AssignActiveWallet;
use Depense\Module\Wallet\Event\WalletCreatedEvent;
use Depense\Module\Wallet\Model\WalletInterface;
use Depense\Module\Wallet\Repository\WalletRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CreateWalletHandler implements HandlerInterface
{
    private WalletRepository $walletRepository;
    private EventDispatcherInterface $eventDispatcher;
    private ActionPerformer $actionPerformer;

    public function __construct(WalletRepository $walletRepository, EventDispatcherInterface $eventDispatcher, ActionPerformer $actionPerformer)
    {
        $this->walletRepository = $walletRepository;
        $this->eventDispatcher = $eventDispatcher;
        $this->actionPerformer = $actionPerformer;
    }

    public function __invoke(CreateWallet $message): WalletInterface
    {
        $wallet = $message->getWallet();

        $this->walletRepository->add($wallet);

        $this->actionPerformer->perform(new AssignActiveWallet($wallet));

        $this->eventDispatcher->dispatch(new WalletCreatedEvent($wallet));

        return $wallet;
    }
}
