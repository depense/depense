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
use Depense\Module\Resource\Model\TimestampableInterface;
use Doctrine\Common\Collections\Collection;
use Serializable;
use Stringable;
use DateTimeInterface;
use Symfony\Component\Security\Core\User\UserInterface as BaseUserInterface;

interface UserInterface extends
    ResourceInterface,
    BaseUserInterface,
    Stringable,
    Serializable,
    TimestampableInterface
{
    public const DEFAULT_ROLE = 'ROLE_USER';

    public function getEmail(): ?string;

    public function setEmail(?string $email): void;

    /**
     * Gets normalized email (should be used in search and sort queries).
     */
    public function getEmailCanonical(): ?string;

    public function setEmailCanonical(?string $emailCanonical): void;

    public function getPlainPassword(): ?string;

    public function setPlainPassword(?string $plainPassword): void;

    public function getLastLogin(): ?DateTimeInterface;

    public function setLastLogin(?DateTimeInterface $time): void;

    /**
     * Never use this to check if this user has access to anything!
     * Use the SecurityContext, or an implementation of AccessDecisionManager
     * instead, e.g.
     *         $securityContext->isGranted('ROLE_USER');
     *
     * @param string $role
     *
     * @return bool
     */
    public function hasRole(string $role): bool;

    public function addRole(string $role): void;

    public function removeRole(string $role): void;

    /**
     * @return Collection|UserOAuthInterface[]
     *
     * @psalm-return Collection<array-key, UserOAuthInterface>
     */
    public function getOAuthAccounts(): Collection;

    public function getOAuthAccount(string $provider): ?UserOAuthInterface;

    public function addOAuthAccount(UserOAuthInterface $oauth): void;
}
