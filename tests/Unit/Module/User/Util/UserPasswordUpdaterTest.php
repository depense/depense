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

namespace Depense\Tests\Unit\Module\User\Util;

use Depense\Module\User\Model\User;
use Depense\Module\User\Util\UserPasswordUpdater;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserPasswordUpdaterTest extends WebTestCase
{
    public function testItUpdatesUserPasswordAndEraseCredentials(): void
    {
        self::bootKernel();

        $passwordEncoder = static::$container->get('security.password_encoder');

        $updater = new UserPasswordUpdater($passwordEncoder);

        $user = new User();
        $user->setPlainPassword('password');


        $updater->updatePassword($user);


        $this->assertNotNull($user->getPassword());
        $this->assertNotEquals('password', $user->getPassword());
        $this->assertNull($user->getPlainPassword());
    }
}
