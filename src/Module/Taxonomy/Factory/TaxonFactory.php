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

namespace Depense\Module\Taxonomy\Factory;

use Depense\Module\Account\Context\AccountContext;
use Depense\Module\Account\Context\AccountNotFoundException;
use Depense\Module\Taxonomy\Model\Taxon;
use Depense\Module\Taxonomy\Model\TaxonInterface;

class TaxonFactory
{
    protected AccountContext $accountContext;

    public function __construct(AccountContext $accountContext)
    {
        $this->accountContext = $accountContext;
    }

    public function create(): TaxonInterface
    {
        try {
            $account = $this->accountContext->getAccount();
        } catch (AccountNotFoundException $exception) {
            $account = null;
        }

        $taxon = new Taxon();
        $taxon->setAccount($account);

        return $taxon;
    }
}
