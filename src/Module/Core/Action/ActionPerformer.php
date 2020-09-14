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

namespace Depense\Module\Core\Action;

use Doctrine\ORM\EntityManagerInterface;
use Throwable;

class ActionPerformer
{
    protected ActionRegistry $actionRegistry;

    protected EntityManagerInterface $entityManager;

    public function __construct(ActionRegistry $actionRegistry, EntityManagerInterface $entityManager)
    {
        $this->actionRegistry = $actionRegistry;
        $this->entityManager = $entityManager;
    }

    public function perform(ActionInterface $action)
    {
        $handler = $this->actionRegistry->getHandler(get_class($action));

        if (null !== $handler && is_callable($handler)) {
            $this->entityManager->beginTransaction();

            try {
                $result = $handler($action);

                $this->entityManager->flush();
                $this->entityManager->commit();

                return $result;
            } catch (Throwable $exception) {
                $this->entityManager->rollback();

                throw $exception;
            }
        }

        return null;
    }
}
