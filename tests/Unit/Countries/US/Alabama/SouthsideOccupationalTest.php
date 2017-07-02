<?php

namespace Appleton\Taxes\Countries\US\Alabama;

use Appleton\Taxes\Countries\US\Alabama\SouthsideOccupational;

class SouthsideOccupationalTest extends \TestCase
{
    public function testSouthsideOccupational()
    {
        $result = $this->app->makeWith(SouthsideOccupational::class, [
            'earnings' => 2300,
        ])->compute();

        $this->assertSame(46.00, $result);
    }
}
