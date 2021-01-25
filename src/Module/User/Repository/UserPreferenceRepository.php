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
use Depense\Module\User\Model\UserPreferenceInterface;

class UserPreferenceRepository extends EntityRepository
{
    /**
     * @param UserInterface|\Symfony\Component\Security\Core\User\UserInterface $user
     *
     * @return UserPreferenceInterface|null
     */
    public function findByUser(UserInterface $user): ?UserPreferenceInterface
    {
        return $this->createQueryBuilder()
            ->andWhere('o.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getOneOrNullResult();
    }
}