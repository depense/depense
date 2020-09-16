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

use Depense\Module\Core\Action\ActionInterface;
use League\OAuth2\Client\Provider\GoogleUser;
use League\OAuth2\Client\Token\AccessTokenInterface;

class RegisterGoogleUser implements ActionInterface
{
    protected GoogleUser $googleUser;

    protected AccessTokenInterface $accessToken;

    public function __construct(GoogleUser $googleUser, AccessTokenInterface $accessToken)
    {
        $this->googleUser = $googleUser;
        $this->accessToken = $accessToken;
    }

    public function getGoogleUser(): GoogleUser
    {
        return $this->googleUser;
    }

    public function getAccessToken(): AccessTokenInterface
    {
        return $this->accessToken;
    }
}
