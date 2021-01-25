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

namespace Depense\Module\Account\Model;

use Depense\Module\Resource\Model\ResourceInterface;
use Depense\Module\User\Model\UserAwareInterface;

interface AccountInterface extends ResourceInterface, UserAwareInterface
{
}