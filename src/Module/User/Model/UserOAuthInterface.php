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

namespace Depense\Module\User\Model;

use Depense\Module\Resource\Model\ResourceInterface;

interface UserOAuthInterface extends ResourceInterface, UserAwareInterface
{
    public function getProvider(): ?string;

    public function setProvider(?string $provider): void;

    public function getIdentifier(): ?string;

    public function setIdentifier(?string $identifier): void;

    public function getAccessToken(): ?string;

    public function setAccessToken(?string $accessToken): void;

    public function getRefreshToken(): ?string;

    public function setRefreshToken(?string $refreshToken): void;
}
