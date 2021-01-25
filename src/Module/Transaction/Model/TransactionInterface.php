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

namespace Depense\Module\Transaction\Model;

use Depense\Module\Account\Model\AccountAwareInterface;
use Depense\Module\Resource\Model\ResourceInterface;
use Depense\Module\Resource\Model\TimestampableInterface;
use Depense\Module\Taxonomy\Model\TaxonInterface;

interface TransactionInterface extends ResourceInterface, AccountAwareInterface, TimestampableInterface
{
    public const TYPE_CREDIT = 'credit';
    public const TYPE_DEBIT = 'debit';

    public function getType(): ?string;

    public function setType(?string $type): void;

    public function getAmount(): int;

    public function setAmount(int $amount): void;

    public function getTaxon(): ?TaxonInterface;

    public function setTaxon(?TaxonInterface $taxon): void;

    public function getDescription(): ?string;

    public function setDescription(?string $description): void;
}
