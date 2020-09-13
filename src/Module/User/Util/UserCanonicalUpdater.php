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

namespace Depense\Module\User\Util;

use Depense\Module\User\Model\UserInterface;

class UserCanonicalUpdater
{
    private Canonicalizer $canonicalizer;

    public function __construct(Canonicalizer $canonicalizer)
    {
        $this->canonicalizer = $canonicalizer;
    }

    public function updateCanonicalFields(UserInterface $user): void
    {
        $user->setEmailCanonical(
            $this->canonicalizeEmail($user->getEmail())
        );
    }

    public function canonicalizeEmail(?string $email): ?string
    {
        return $this->canonicalizer->canonicalize($email);
    }
}
