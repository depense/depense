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

class Canonicalizer
{
    public function canonicalize(?string $string): ?string
    {
        if (null !== $string) {
            $encoding = mb_detect_encoding($string);

            return mb_detect_encoding($string)
                ? mb_convert_case($string, MB_CASE_LOWER, $encoding)
                : mb_convert_case($string, MB_CASE_LOWER);
        }

        return null;
    }
}
