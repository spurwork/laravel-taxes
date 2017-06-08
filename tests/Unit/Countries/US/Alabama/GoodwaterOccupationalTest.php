<?php

namespace Appleton\Taxes\Countries\US\Alabama;

use Appleton\Taxes\Countries\US\Alabama\GoodwaterOccupational;

class GoodwaterOccupationalTest extends \TestCase
{
    public function testGoodwaterOccupational()
    {
        $taxes = $this->app->make(GoodwaterOccupational::class);

        $result = $taxes
            ->withEarnings(2300)
            ->compute();

        $this->assertSame(17.25, $result);
    }
}
