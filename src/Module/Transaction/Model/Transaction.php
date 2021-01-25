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

use Depense\Module\Account\Model\AccountInterface;
use Depense\Module\Resource\Model\TimestampableTrait;
use Depense\Module\Taxonomy\Model\TaxonInterface;

class Transaction implements TransactionInterface
{
    use TimestampableTrait;

    protected ?string $id = null;
    protected ?AccountInterface $account = null;
    protected int $amount = 0;
    protected ?string $type = null;
    protected ?TaxonInterface $taxon = null;
    protected ?string $description = null;

    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->id;
    }

    public function getAccount(): ?AccountInterface
    {
        return $this->account;
    }

    public function setAccount(?AccountInterface $account): void
    {
        $this->account = $account;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    public function getTaxon(): ?TaxonInterface
    {
        return $this->taxon;
    }

    public function setTaxon(?TaxonInterface $taxon): void
    {
        $this->taxon = $taxon;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
}
