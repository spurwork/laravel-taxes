<?php

namespace Appleton\Taxes\Countries\US\Alabama;

use Appleton\Taxes\Countries\US\Alabama\MossesOccupational;

class MossesOccupationalTest extends \TestCase
{
    public function testMossesOccupational()
    {
        $taxes = $this->app->make(MossesOccupational::class);

        $result = $taxes
            ->withEarnings(2300)
            ->compute();

        $this->assertSame(23.00, $result);
    }
}
