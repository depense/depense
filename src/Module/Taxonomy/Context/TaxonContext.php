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

namespace Depense\Module\Taxonomy\Context;

use Depense\Module\Account\Context\AccountContext;
use Depense\Module\Taxonomy\Repository\TaxonRepository;

class TaxonContext
{
    protected AccountContext $accountContext;
    protected TaxonRepository $taxonRepository;

    public function __construct(AccountContext $accountContext, TaxonRepository $taxonRepository)
    {
        $this->accountContext = $accountContext;
        $this->taxonRepository = $taxonRepository;
    }

    public function getTaxa(): array
    {
        if (!isset($this->taxa)) {
            $this->taxa = $this->taxonRepository->findByAccount(
                $this->accountContext->getAccount()
            );
        }

        return $this->taxa;
    }
}
