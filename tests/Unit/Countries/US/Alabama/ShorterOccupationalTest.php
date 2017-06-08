<?php

namespace Appleton\Taxes\Countries\US\Alabama;

use Appleton\Taxes\Countries\US\Alabama\ShorterOccupational;

class ShorterOccupationalTest extends \TestCase
{
    public function testShorterOccupational()
    {
        $taxes = $this->app->make(ShorterOccupational::class);

        $result = $taxes
            ->withEarnings(2300)
            ->compute();

        $this->assertSame(23.00, $result);
    }
}
