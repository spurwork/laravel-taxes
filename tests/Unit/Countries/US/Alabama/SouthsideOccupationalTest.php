<?php

namespace Appleton\Taxes\Countries\US\Alabama;

use Appleton\Taxes\Countries\US\Alabama\SouthsideOccupational;

class SouthsideOccupationalTest extends \TestCase
{
    public function testSouthsideOccupational()
    {
        $taxes = $this->app->make(SouthsideOccupational::class);

        $result = $taxes
            ->withEarnings(2300)
            ->compute();

        $this->assertSame(46.00, $result);
    }
}
