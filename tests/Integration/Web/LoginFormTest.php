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

namespace Depense\Tests\Integration\Web;

use Depense\Module\User\DataFixtures\UserFixtures;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Depense\Tests\Integration\DataFixtures;

class LoginFormTest extends WebTestCase
{
    use DataFixtures;

    public function testAnonymousUserCannotAccessToAppOverview(): void
    {
        $client = static::createClient();

        $client->request('GET', '/app/overview');

        $this->assertResponseRedirects('/login');

        $client->followRedirect();

        $this->assertResponseIsSuccessful();
    }

    public function testIncorrectLoginAttemptWillRedirectsToLoginPath(): void
    {
        $client = static::createClient();

        $client->request('GET', '/login');

        $client->submitForm('btnLogin', [
            'username' => 'foo@bar.com',
            'password' => 'invalid_password'
        ]);

        $this->assertResponseRedirects('/login');
    }

    public function testValidLoginAttemptWillRedirectsToAppOverview(): void
    {
        $client = static::createClient();

        $this->loadFixtures([
            UserFixtures::class
        ]);

        $client->request('GET', '/login');

        $client->submitForm('btnLogin', [
            'username' => 'test@mail.com',
            'password' => 'password'
        ]);

        $this->assertResponseRedirects('/app/overview');

        $client->followRedirect();

        $this->assertResponseIsSuccessful();
    }
}
