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

namespace Depense\Module\User\Context;

use Depense\Module\User\Model\UserInterface;
use Symfony\Component\Security\Core\Security;

class UserContext
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function getUser(): UserInterface
    {
        if (!isset($this->user)) {
            if (null === $user = $this->security->getUser()) {
                throw new UserNotFoundException();
            }

            $this->user = $user;
        }

        return $this->user;
    }

}
