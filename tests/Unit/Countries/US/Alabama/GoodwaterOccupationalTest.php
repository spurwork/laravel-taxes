<?php

namespace Appleton\Taxes\Countries\US\Alabama\GoodwaterOccupational;

class GoodwaterOccupationalTest extends \TestCase
{
    public function testGoodwaterOccupational()
    {
        $result = $this->app->makeWith(GoodwaterOccupational::class, [
            'earnings' => 2300,
        ])->compute();

        $this->assertSame(17.25, $result);
    }
}
