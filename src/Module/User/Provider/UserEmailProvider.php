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

namespace Depense\Module\User\Provider;

use Depense\Module\User\Manager\UserManagerInterface;
use Depense\Module\User\Model\User;
use Depense\Module\User\Repository\UserRepository;
use Depense\Module\User\Util\Canonicalizer;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Depense\Module\User\Model\UserInterface as DepenseUserInterface;

class UserEmailProvider implements UserProviderInterface
{
    protected UserManagerInterface $userManager;

    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @inheritDoc
     */
    public function loadUserByUsername(string $username)
    {
        $user = $this->userManager->findUserByEmail($username);

        if (null === $user) {
            throw new UsernameNotFoundException(
                sprintf('Email "%s" does not exist.', $username)
            );
        }

        return $user;
    }

    /**
     * @inheritDoc
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof DepenseUserInterface) {
            throw new UnsupportedUserException(
                sprintf('User must implement "%s", instance of "%s" given', DepenseUserInterface::class, get_class($user))
            );
        }

        if (null === $reloadedUser = $this->userManager->findUserById($user->getId())) {
            throw new UsernameNotFoundException(
                sprintf('User with ID "%d" could not be refreshed.', $user->getId())
            );
        }

        return $reloadedUser;
    }

    /**
     * @inheritDoc
     */
    public function supportsClass(string $class)
    {
        return User::class === $class || is_subclass_of($class, DepenseUserInterface::class);
    }
}
