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

namespace Depense\Module\User\Util;

use Depense\Module\User\Model\UserInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserPasswordUpdater
{
    private UserPasswordEncoderInterface $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    public function updatePassword(UserInterface $user): void
    {
        if (!empty($user->getPlainPassword())) {
            $user->setPassword(
                $this->userPasswordEncoder->encodePassword($user, $user->getPlainPassword())
            );
            $user->eraseCredentials();
        }
    }
}
