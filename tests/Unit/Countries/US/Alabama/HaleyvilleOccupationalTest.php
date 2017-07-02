<?php

namespace Appleton\Taxes\Countries\US\Alabama\HaleyvilleOccupational;

class HaleyvilleOccupationalTest extends \TestCase
{
    public function testHaleyvilleOccupational()
    {
        $result = $this->app->makeWith(HaleyvilleOccupational::class, [
            'earnings' => 2300,
        ])->compute();

        $this->assertSame(23.00, $result);
    }
}
