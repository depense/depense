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

namespace Depense\Module\Resource\Repository;

use Depense\Module\Resource\Model\ResourceInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * This class should be extended by all modules model repositories.
 */
class EntityRepository implements RepositoryInterface
{
    protected EntityManagerInterface $entityManager;

    protected string $className;

    public function __construct(string $className, EntityManagerInterface $entityManager)
    {
        $this->className = $className;
        $this->entityManager = $entityManager;
    }

    /**
     * @inheritDoc
     */
    public function add(ResourceInterface $resource): void
    {
        $this->entityManager->persist($resource);
    }

    /**
     * @inheritDoc
     */
    public function remove(ResourceInterface $resource): void
    {
        $this->entityManager->remove($resource);
    }

    /**
     * @inheritDoc
     */
    public function findById($resourceId): ?object
    {
        return $this->entityManager->find($this->className, $resourceId);
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return $this->entityManager->createQueryBuilder()
            ->select('COUNT(o.id)')
            ->from($this->className, 'o')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
