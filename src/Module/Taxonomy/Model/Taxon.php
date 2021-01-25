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

use Depense\Module\Account\Model\AccountInterface;
use Depense\Module\Resource\Model\TimestampableTrait;

class Taxon implements TaxonInterface
{
    use TimestampableTrait;

    protected ?int $id = null;

    protected ?AccountInterface $account = null;

    protected ?string $code = null;

    protected ?string $name = null;

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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }
}
