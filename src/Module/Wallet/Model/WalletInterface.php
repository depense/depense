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

use Depense\Module\Account\Model\AccountAwareInterface;
use Depense\Module\Resource\Model\ResourceInterface;
use Depense\Module\Resource\Model\TimestampableInterface;

interface WalletInterface extends ResourceInterface, AccountAwareInterface, TimestampableInterface
{
    public function getName(): ?string;

    public function setName(string $name): void;

    public function getCurrency(): ?string;

    public function setCurrency(string $currency): void;

    public function getBalance(): int;

    public function setBalance(int $balance): void;
}
