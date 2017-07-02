<?php

namespace Appleton\Taxes\Countries\US\Alabama;

use Appleton\Taxes\Countries\US\Alabama\ShorterOccupational;

class ShorterOccupationalTest extends \TestCase
{
    public function testShorterOccupational()
    {
        $result = $this->app->makeWith(ShorterOccupational::class, [
            'earnings' => 2300,
        ])->compute();

        $this->assertSame(23.00, $result);
    }
}
