<?php

namespace Appleton\Taxes\Countries\US\Alabama;

use Appleton\Taxes\Countries\US\Alabama\GadsdenOccupational;

class GadsdenOccupationalTest extends \TestCase
{
    public function testGadsdenOccupational()
    {
        $taxes = $this->app->make(GadsdenOccupational::class);

        $result = $taxes
            ->withEarnings(2300)
            ->compute();

        $this->assertSame(46.00, $result);
    }
}
