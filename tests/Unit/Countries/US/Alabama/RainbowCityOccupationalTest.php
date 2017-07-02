<?php

namespace Appleton\Taxes\Countries\US\Alabama\RainbowCityOccupational;

class RainbowCityOccupationalTest extends \TestCase
{
    public function testRainbowCityOccupational()
    {
        $result = $this->app->makeWith(RainbowCityOccupational::class, [
            'earnings' => 2300,
        ])->compute();

        $this->assertSame(46.00, $result);
    }
}
