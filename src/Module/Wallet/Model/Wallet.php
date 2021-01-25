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

namespace Depense\Module\Wallet\Model;

use Depense\Module\Account\Model\AccountInterface;
use Depense\Module\Resource\Model\TimestampableTrait;

class Wallet implements WalletInterface
{
    use TimestampableTrait;

    protected ?int $id = null;

    protected ?AccountInterface $account = null;

    protected ?string $name = null;

    protected ?string $currency = null;

    protected int $balance = 0;

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    public function getBalance(): int
    {
        return $this->balance;
    }

    public function setBalance(int $balance): void
    {
        $this->balance = $balance;
    }
}
