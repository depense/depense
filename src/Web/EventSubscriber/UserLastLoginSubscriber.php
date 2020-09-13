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

namespace Depense\Web\EventSubscriber;

use Depense\Module\Core\Action\ActionPerformer;
use Depense\Module\User\Action\UpdateUserLastLogin;
use Depense\Module\User\Model\UserInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;

class UserLastLoginSubscriber implements EventSubscriberInterface
{
    protected ActionPerformer $actionPerformer;

    public function __construct(ActionPerformer $actionPerformer)
    {
        $this->actionPerformer = $actionPerformer;
    }

    public function onLoginSuccess(LoginSuccessEvent $event): void
    {
        $user = $event->getUser();

        if (!$user instanceof UserInterface) {
            throw new UnexpectedValueException(
                sprintf('In order to use this subscriber, your class should implement "%s".', UserInterface::class)
            );
        }

        $this->actionPerformer->perform(
            new UpdateUserLastLogin($user)
        );
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return [
            LoginSuccessEvent::class => 'onLoginSuccess'
        ];
    }
}
