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

namespace Depense\Module\Wallet\Repository;

use Depense\Module\Account\Model\AccountInterface;
use Depense\Module\Resource\Repository\EntityRepository;
use Depense\Module\Wallet\Model\WalletInterface;

class WalletRepository extends EntityRepository
{
    /**
     * @param AccountInterface $account
     *
     * @return WalletInterface[]
     */
    public function findByAccount(AccountInterface $account): array
    {
        return $this->createQueryBuilder()
            ->andWhere('o.account = :account')
            ->setParameter('account', $account)
            ->getQuery()
            ->getResult();
    }
}
