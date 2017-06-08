<?php

namespace Appleton\Taxes\Countries\US\Alabama;

use Appleton\Taxes\Countries\US\Alabama\AuburnOccupational;

class AuburnOccupationalTest extends \TestCase
{
    public function testAuburnOccupational()
    {
        $taxes = $this->app->make(AuburnOccupational::class);

        $result = $taxes
            ->withEarnings(2300)
            ->compute();

        $this->assertSame(23.00, $result);
    }
}
