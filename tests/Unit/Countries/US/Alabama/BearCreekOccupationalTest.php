<?php

namespace Appleton\Taxes\Countries\US\Alabama\BearCreekOccupational;

class BearCreekOccupationalTest extends \TestCase
{
    public function testBearCreekOccupational()
    {
        $result = $this->app->makeWith(BearCreekOccupational::class, [
            'earnings' => 2300,
        ])->compute();

        $this->assertSame(23.00, $result);
    }
}
