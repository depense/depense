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
use Depense\Module\User\Util\Canonicalizer;
use Depense\Module\User\Util\UserCanonicalUpdater;
use PHPUnit\Framework\TestCase;

class UserCanonicalUpdaterTest extends TestCase
{
    public function testItConvertsEmailToCanonical(): void
    {
        $updater = new UserCanonicalUpdater(
            $canonicalizer = new Canonicalizer()
        );

        $user = new User();
        $user->setEmail('foO@bBr.com');

        $updater->updateCanonicalFields($user);

        $this->assertNotEquals('foO@bBr.com', $user->getEmailCanonical());
        $this->assertEquals($canonicalizer->canonicalize('foO@bBr.com'), $user->getEmailCanonical());
    }
}
