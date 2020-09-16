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

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterUserTest extends WebTestCase
{
    public function testRegisterUserAndThenAuthenticateHim(): void
    {
        $client = static::createClient();

        $client->catchExceptions(false);

        $client->request('GET', '/register');

        $client->submitForm('btnRegister', [
            'register_user[email]' => 'foo@bar.com',
            'register_user[plainPassword][first]' => 'password',
            'register_user[plainPassword][second]' => 'password'
        ]);

        $this->assertResponseRedirects('/app/overview');
    }

    public function testRegisterUserWithInvalidData(): void
    {
        $client = static::createClient();

        $client->catchExceptions(false);

        $client->request('GET', '/register');

        $client->submitForm('btnRegister', [
            'register_user[email]' => '',
            'register_user[plainPassword][first]' => 'password',
            'register_user[plainPassword][second]' => 'password'
        ]);

        // Blank email
        $this->assertRouteSame('root_register_user');

        $client->submitForm('btnRegister', [
            'register_user[email]' => 'foo@bar.com',
            'register_user[plainPassword][first]' => '',
            'register_user[plainPassword][second]' => ''
        ]);

        // Blank password
        $this->assertRouteSame('root_register_user');

        $client->submitForm('btnRegister', [
            'register_user[email]' => 'foo@bar.com',
            'register_user[plainPassword][first]' => 'foobar',
            'register_user[plainPassword][second]' => 'foobaz'
        ]);

        // Not matching passwords
        $this->assertRouteSame('root_register_user');

        $client->submitForm('btnRegister', [
            'register_user[email]' => 'foo@bar.com',
            'register_user[plainPassword][first]' => 'foobar',
            'register_user[plainPassword][second]' => 'foobar'
        ]);

        // Valid data
        $this->assertResponseRedirects('/app/overview');
    }
}
