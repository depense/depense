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

use DateTime;
use Depense\Module\Resource\Model\TimestampableTrait;
use DateTimeInterface;
use Depense\Module\User\Enum\UserRole;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class User implements UserInterface
{
    use TimestampableTrait;

    protected ?int $id = null;

    protected ?string $email = null;

    /**
     * Normalized representation of an email.
     *
     * @var string|null
     */
    protected ?string $emailCanonical = null;

    /**
     * Encrypted password. Must be persisted.
     *
     * @var string|null
     */
    protected ?string $password = null;

    /**
     * Password before encryption. Used for model validation. Must not be persisted.
     *
     * @var string|null
     */
    protected ?string $plainPassword = null;

    /**
     * We need at least one role to be able to authenticate.
     *
     * @var array
     */
    protected array $roles = [UserRole::DEFAULT];

    protected ?DateTimeInterface $lastLogin = null;

    /**
     * @var Collection|UserOAuthInterface[]
     *
     * @psalm-var Collection<array-key, UserOAuthInterface>
     */
    protected Collection $oauthAccounts;

    protected ?string $firstName;

    protected ?string $lastName;

    public function __construct()
    {
        $this->createdAt = new DateTime();

        /** @var ArrayCollection<array-key, UserOAuthInterface> $this->oauthAccounts */
        $this->oauthAccounts = new ArrayCollection();
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return (string)$this->getUsername();
    }

    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getEmailCanonical(): ?string
    {
        return $this->emailCanonical;
    }

    public function setEmailCanonical(?string $emailCanonical): void
    {
        $this->emailCanonical = $emailCanonical;
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->email;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @inheritDoc
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    public function setLastLogin(?DateTimeInterface $time): void
    {
        $this->lastLogin = $time;
    }

    public function getLastLogin(): ?DateTimeInterface
    {
        return $this->lastLogin;
    }

    /**
     * @inheritDoc
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @inheritDoc
     */
    public function hasRole(string $role): bool
    {
        return in_array(strtoupper($role), $this->getRoles(), true);
    }

    public function addRole(string $role): void
    {
        $role = strtoupper($role);

        if (!in_array($role, $this->roles, true)) {
            $this->roles[] = $role;
        }
    }

    public function removeRole(string $role): void
    {
        if (false !== $key = array_search(strtoupper($role), $this->roles, true)) {
            unset($this->roles[$key]);
            $this->roles = array_values($this->roles);
        }
    }

    /**
     * @inheritDoc
     */
    public function getOAuthAccounts(): Collection
    {
        return $this->oauthAccounts;
    }

    public function getOAuthAccount(string $provider): ?UserOAuthInterface
    {
        if ($this->oauthAccounts->isEmpty()) {
            return null;
        }

        $filtered = $this->oauthAccounts->filter(function (UserOAuthInterface $oauth) use ($provider): bool {
            return $provider === $oauth->getProvider();
        });

        if ($filtered->isEmpty()) {
            return null;
        }

        return $filtered->current();
    }

    public function addOAuthAccount(UserOAuthInterface $oauth): void
    {
        if (!$this->oauthAccounts->contains($oauth)) {
            $this->oauthAccounts->add($oauth);
            $oauth->setUser($this);
        }
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials(): void
    {
        $this->plainPassword = null;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        // No need to use salt for argon2i algo.
    }

    /**
     * @inheritDoc
     */
    public function serialize(): string
    {
        return serialize([
            $this->password,
            $this->email,
            $this->id,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function unserialize($serialized): void
    {
        $data = unserialize($serialized);

        [
            $this->password,
            $this->email,
            $this->id,
        ] = $data;
    }
}
