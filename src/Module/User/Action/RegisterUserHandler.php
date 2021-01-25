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

use Depense\Module\Account\Action\CreateAccount;
use Depense\Module\Core\Action\ActionPerformer;
use Depense\Module\Core\Action\HandlerInterface;
use Depense\Module\User\Event\UserRegisteredEvent;
use Depense\Module\User\Manager\UserManagerInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class RegisterUserHandler implements HandlerInterface
{
    private UserManagerInterface $userManager;

    private EventDispatcherInterface $eventDispatcher;

    private ActionPerformer $actionPerformer;

    public function __construct(UserManagerInterface $userManager, EventDispatcherInterface $eventDispatcher, ActionPerformer $actionPerformer)
    {
        $this->userManager = $userManager;
        $this->eventDispatcher = $eventDispatcher;
        $this->actionPerformer = $actionPerformer;
    }

    public function __invoke(RegisterUser $registerUser)
    {
        $user = $registerUser->getUser();

        $this->userManager->updateUser($user);

        $this->actionPerformer->perform(new CreateUserPreference($user));
        $this->actionPerformer->perform(new CreateAccount($user));

        $this->eventDispatcher->dispatch(new UserRegisteredEvent($user));
    }
}
