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

namespace Depense\Tests\Unit\Module\User\Action;

use Depense\Module\User\Action\UpdateUserLastLogin;
use Depense\Module\User\Action\UpdateUserLastLoginHandler;
use Depense\Module\User\Model\User;
use PHPUnit\Framework\TestCase;

/**
 * @group time-sensitive
 */
class UpdateUserLastLoginHandlerTest extends TestCase
{
    public function testUpdateUserLastLogin(): void
    {
        $handler = new UpdateUserLastLoginHandler();

        $handler(new UpdateUserLastLogin($user = new User()));

        $this->assertNotNull($user->getLastLogin());
        $this->assertEquals(time(), $user->getLastLogin()->getTimestamp());
    }
}
