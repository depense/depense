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

namespace Depense\Tests\Unit\Module\Core\Action\Fixtures;

use Depense\Module\Core\Action\HandlerInterface;

class DummyHandler implements HandlerInterface
{
    public function __invoke(Dummy $action)
    {
        // do something

        return $action->getMessage();
    }
}
