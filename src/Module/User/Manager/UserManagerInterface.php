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

namespace Depense\Module\User\Manager;

use Depense\Module\User\Model\UserInterface;

interface UserManagerInterface
{
    /**
     * Find a user by his email/emailCanonical attributes.
     *
     * @param string|null $email
     *
     * @return UserInterface|null
     */
    public function findUserByEmail(?string $email): ?UserInterface;

    /**
     * Find a user by his unique identifier.
     *
     * @param int|null $id
     *
     * @return UserInterface|null
     */
    public function findUserById(?int $id): ?UserInterface;

    /**
     * Deletes a user.
     *
     * @param UserInterface $user
     */
    public function deleteUser(UserInterface $user): void;

    /**
     * Updates a user.
     *
     * @param UserInterface $user
     */
    public function updateUser(UserInterface $user): void;
}
