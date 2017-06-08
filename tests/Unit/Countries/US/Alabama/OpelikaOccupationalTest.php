<?php

namespace Appleton\Taxes\Countries\US\Alabama;

use Appleton\Taxes\Countries\US\Alabama\OpelikaOccupational;

class OpelikaOccupationalTest extends \TestCase
{
    public function testOpelikaOccupational()
    {
        $taxes = $this->app->make(OpelikaOccupational::class);

        $result = $taxes
            ->withEarnings(2300)
            ->compute();

        $this->assertSame(34.5, $result);
    }
}
