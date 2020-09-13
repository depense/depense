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

namespace Depense\Tests\Unit\Module\User\Util;

use Depense\Module\User\Util\Canonicalizer;
use PHPUnit\Framework\TestCase;

class CanonicalizerTest extends TestCase
{
    public function testConvertsStringsToLowerCase(): void
    {
        $canonicalizer = new Canonicalizer();
        $result = $canonicalizer->canonicalize('tEsTsTrInG');

        $this->assertEquals('teststring', $result);
    }
}
