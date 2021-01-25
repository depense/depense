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

class RegisterTest extends WebTestCase
{
    public function testRegisterUserAndThenAuthenticateHim(): void
    {
        $client = static::createClient();

        $client->catchExceptions(false);

        $client->request('GET', '/register');

        $client->submitForm('btnRegister', [
            'register[email]' => 'foo@bar.com',
            'register[firstName]' => 'foo',
            'register[lastName]' => 'bar',
            'register[plainPassword]' => 'password'
        ]);

        $this->assertResponseRedirects('/app/overview');
    }

    public function testRegisterUserWithInvalidData(): void
    {
        $client = static::createClient();

        $client->catchExceptions(false);

        $client->request('GET', '/register');

        $client->submitForm('btnRegister', [
            'register[email]' => '',
            'register[firstName]' => 'foo',
            'register[lastName]' => 'bar',
            'register[plainPassword]' => 'password'
        ]);

        // Blank email
        $this->assertRouteSame('root_register');

        $client->submitForm('btnRegister', [
            'register[email]' => 'foo@bar.com',
            'register[firstName]' => 'foo',
            'register[lastName]' => 'bar',
            'register[plainPassword]' => ''
        ]);

        // Blank password
        $this->assertRouteSame('root_register');

        $client->submitForm('btnRegister', [
            'register[email]' => 'foo@bar.com',
            'register[firstName]' => '',
            'register[lastName]' => 'bar',
            'register[plainPassword]' => 'foobar'
        ]);

        // Blank first name
        $this->assertRouteSame('root_register');

        $client->submitForm('btnRegister', [
            'register[email]' => 'foo@bar.com',
            'register[firstName]' => 'foo',
            'register[lastName]' => '',
            'register[plainPassword]' => 'foobar'
        ]);

        // Blank last name
        $this->assertRouteSame('root_register');

        $client->submitForm('btnRegister', [
            'register[email]' => 'foo@bar.com',
            'register[firstName]' => 'foo',
            'register[lastName]' => 'bar',
            'register[plainPassword]' => 'foobar'
        ]);

        // Valid data
        $this->assertResponseRedirects('/app/overview');
    }
}
