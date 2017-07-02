<?php

namespace Appleton\Taxes\Countries\US\Alabama\GadsdenOccupational;

class GadsdenOccupationalTest extends \TestCase
{
    public function testGadsdenOccupational()
    {
        $result = $this->app->makeWith(GadsdenOccupational::class, [
            'earnings' => 2300,
        ])->compute();

        $this->assertSame(46.00, $result);
    }
}
