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
use Depense\Module\User\Model\UserOAuthInterface;

class UserOAuthRepository extends EntityRepository
{
    public function findOne(string $provider, string $identifier): ?UserOAuthInterface
    {
        return $this->createQueryBuilder()
            ->andWhere('o.provider = :provider')
            ->andWhere('o.identifier = :identifier')
            ->setParameter('provider', $provider)
            ->setParameter('identifier', $identifier)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
