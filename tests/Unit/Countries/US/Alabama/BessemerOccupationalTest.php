<?php

namespace Appleton\Taxes\Countries\US\Alabama;

use Appleton\Taxes\Countries\US\Alabama\BessemerOccupational;

class BessemerOccupationalTest extends \TestCase
{
    public function testBessemerOccupational()
    {
        $taxes = $this->app->make(BessemerOccupational::class);

        $result = $taxes
            ->withEarnings(2300)
            ->compute();

        $this->assertSame(23.00, $result);
    }
}
