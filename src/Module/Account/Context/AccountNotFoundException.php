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

namespace Depense\Module\Account\Context;

use RuntimeException;
use Throwable;

class AccountNotFoundException extends RuntimeException
{
    public function __construct(Throwable $previous = null)
    {
        $message = 'Account could not be found!';

        parent::__construct($message, 0, $previous);
    }
}