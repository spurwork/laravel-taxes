<?php

namespace Appleton\Taxes\Countries\US\Alabama;

use Appleton\Taxes\Countries\US\Alabama\HaleyvilleOccupational;

class HaleyvilleOccupationalTest extends \TestCase
{
    public function testHaleyvilleOccupational()
    {
        $taxes = $this->app->make(HaleyvilleOccupational::class);

        $result = $taxes
            ->withEarnings(2300)
            ->compute();

        $this->assertSame(23.00, $result);
    }
}
