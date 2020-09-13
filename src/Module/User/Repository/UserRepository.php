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

namespace Depense\Module\User\Repository;

use Depense\Module\Resource\Repository\EntityRepository;
use Depense\Module\User\Model\UserInterface;

/**
 * @method UserInterface|null findById($resourceId)
 */
class UserRepository extends EntityRepository
{
    /**
     * Search a one user by emailCanonical field.
     *
     * @param string|null $email
     *
     * @return UserInterface|null
     */
    public function findByEmailCanonical(?string $email): ?UserInterface
    {
        return $this->createQueryBuilder()
            ->andWhere('o.emailCanonical = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
