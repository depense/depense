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
use DateTime;

class UpdateUserLastLoginHandler implements HandlerInterface
{
    public function __invoke(UpdateUserLastLogin $message): void
    {
        $user = $message->getUser();

        $user->setLastLogin(new DateTime());
    }
}
