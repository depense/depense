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

class ActionRegistry
{
    protected array $actions = [];
    protected array $handlers = [];

    /**
     * This method should be called BEFORE the AddAction() method.
     *
     * @param HandlerInterface $handler
     */
    public function addHandler(HandlerInterface $handler): void
    {
        $this->handlers[get_class($handler)] = $handler;
    }

    /**
     * This method should be called AFTER the addHandler() method.
     *
     * @param string $actionClass
     */
    public function addAction(string $actionClass): void
    {
        $handlerClass = $actionClass . 'Handler';
        $handler = null;

        if (array_key_exists($handlerClass, $this->handlers)) {
            $handler = $this->handlers[$handlerClass];
        }

        $this->actions[$actionClass] = $handler;
    }

    /**
     * @return HandlerInterface[]
     */
    public function getActions(): array
    {
        return $this->actions;
    }

    /**
     * @param string $actionClass
     *
     * @return HandlerInterface
     */
    public function getHandler(string $actionClass): HandlerInterface
    {
        return $this->actions[$actionClass];
    }

    /**
     * @return HandlerInterface[]
     */
    public function getHandlers(): array
    {
        return $this->handlers;
    }
}
