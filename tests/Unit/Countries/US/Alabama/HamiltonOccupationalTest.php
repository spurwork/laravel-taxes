<?php

namespace Appleton\Taxes\Countries\US\Alabama;

use Appleton\Taxes\Countries\US\Alabama\HamiltonOccupational;

class HamiltonOccupationalTest extends \TestCase
{
    public function testHamiltonOccupational()
    {
        $taxes = $this->app->make(HamiltonOccupational::class);

        $result = $taxes
            ->withEarnings(2300)
            ->compute();

        $this->assertSame(23.00, $result);
    }
}
