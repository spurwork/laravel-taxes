<?php

namespace Appleton\Taxes\Countries\US\Alabama;

use Appleton\Taxes\Countries\US\Alabama\GlencoeOccupational;

class GlencoeOccupationalTest extends \TestCase
{
    public function testGlencoeOccupational()
    {
        $taxes = $this->app->make(GlencoeOccupational::class);

        $result = $taxes
            ->withEarnings(2300)
            ->compute();

        $this->assertSame(46.00, $result);
    }
}
