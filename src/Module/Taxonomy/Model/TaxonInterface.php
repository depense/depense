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

namespace Depense\Module\Taxonomy\Model;

use Depense\Module\Account\Model\AccountAwareInterface;
use Depense\Module\Resource\Model\ResourceInterface;
use Depense\Module\Resource\Model\TimestampableInterface;

interface TaxonInterface extends ResourceInterface, TimestampableInterface, AccountAwareInterface
{
    public function getCode(): ?string;

    public function setCode(?string $code): void;

    public function getName(): ?string;

    public function setName(?string $name): void;
}
