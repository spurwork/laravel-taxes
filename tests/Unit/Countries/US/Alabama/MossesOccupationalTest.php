<?php

namespace Appleton\Taxes\Countries\US\Alabama\MossesOccupational;

class MossesOccupationalTest extends \TestCase
{
    public function testMossesOccupational()
    {
        $result = $this->app->makeWith(MossesOccupational::class, [
            'earnings' => 2300,
        ])->compute();

        $this->assertSame(23.00, $result);
    }
}
