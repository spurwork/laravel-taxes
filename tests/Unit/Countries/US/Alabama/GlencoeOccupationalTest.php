<?php

namespace Appleton\Taxes\Countries\US\Alabama\GlencoeOccupational;

class GlencoeOccupationalTest extends \TestCase
{
    public function testGlencoeOccupational()
    {
        $result = $this->app->makeWith(GlencoeOccupational::class, [
            'earnings' => 2300,
        ])->compute();

        $this->assertSame(46.00, $result);
    }
}
