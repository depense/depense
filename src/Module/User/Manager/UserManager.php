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
use Depense\Module\User\Repository\UserRepository;
use Depense\Module\User\Util\UserCanonicalUpdater;
use Depense\Module\User\Util\UserPasswordUpdater;
use Doctrine\ORM\EntityManagerInterface;

class UserManager implements UserManagerInterface
{
    protected UserRepository $userRepository;

    protected UserCanonicalUpdater $canonicalUpdater;

    protected UserPasswordUpdater $passwordUpdater;

    protected EntityManagerInterface $entityManager;

    public function __construct(
        UserRepository $userRepository,
        UserCanonicalUpdater $canonicalUpdater,
        UserPasswordUpdater $passwordUpdater,
        EntityManagerInterface $entityManager)
    {
        $this->userRepository = $userRepository;
        $this->canonicalUpdater = $canonicalUpdater;
        $this->passwordUpdater = $passwordUpdater;
        $this->entityManager = $entityManager;
    }

    /**
     * @inheritDoc
     */
    public function findUserByEmail(?string $email): ?UserInterface
    {
        return $this->userRepository->findByEmailCanonical(
            $this->canonicalUpdater->canonicalizeEmail($email)
        );
    }

    /**
     * @inheritDoc
     */
    public function findUserById(?int $id): ?UserInterface
    {
        return $this->userRepository->findById($id);
    }

    /**
     * @inheritDoc
     */
    public function deleteUser(UserInterface $user): void
    {
        $this->userRepository->remove($user);

        $this->entityManager->flush();
    }

    /**
     * @inheritDoc
     */
    public function updateUser(UserInterface $user): void
    {
        $this->canonicalUpdater->updateCanonicalFields($user);
        $this->passwordUpdater->updatePassword($user);

        if (null === $user->getId()) {
            $this->userRepository->add($user);
        }

        $this->entityManager->flush();
    }
}
