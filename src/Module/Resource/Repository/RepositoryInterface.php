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

interface RepositoryInterface
{
    public const ORDER_ASCENDING = 'ASC';

    public const ORDER_DESCENDING = 'DESC';

    /**
     * Add a resource to the current repository collection.
     *
     * @param ResourceInterface $resource
     */
    public function add(ResourceInterface $resource): void;

    /**
     * Remove a resource from the current repository collection.
     *
     * @param ResourceInterface $resource
     */
    public function remove(ResourceInterface $resource): void;

    /**
     * Find a resource by it's ID.
     *
     * @param $resourceId
     *
     * @return object|ResourceInterface|null
     */
    public function findById($resourceId): ?object;

    /**
     * Count the current repository collection.
     *
     * @return int
     */
    public function count(): int;
}
