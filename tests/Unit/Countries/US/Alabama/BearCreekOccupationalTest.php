<?php

namespace Appleton\Taxes\Countries\US\Alabama;

use Appleton\Taxes\Countries\US\Alabama\BearCreekOccupational;

class BearCreekOccupationalTest extends \TestCase
{
    public function testBearCreekOccupational()
    {
        $taxes = $this->app->make(BearCreekOccupational::class);

        $result = $taxes
            ->withEarnings(2300)
            ->compute();

        $this->assertSame(23.00, $result);
    }
}
