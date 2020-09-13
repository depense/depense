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

class ActionPerformer
{
    protected ActionRegistry $actionRegistry;

    public function __construct(ActionRegistry $actionRegistry)
    {
        $this->actionRegistry = $actionRegistry;
    }

    public function perform(ActionInterface $action)
    {
        if (null !== $handler = $this->actionRegistry->getHandler(get_class($action))) {
            if (is_callable($handler)) {
                return $handler($action);
            }
        }

        return null;
    }
}
