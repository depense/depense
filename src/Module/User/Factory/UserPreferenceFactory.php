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

namespace Depense\Module\User\Factory;

use Depense\Module\User\Model\UserInterface;
use Depense\Module\User\Model\UserPreference;
use Depense\Module\User\Model\UserPreferenceInterface;

class UserPreferenceFactory
{
    public function createForUser(UserInterface $user): UserPreferenceInterface
    {
        $preference = new UserPreference();
        $preference->setUser($user);

        return $preference;
    }
}
