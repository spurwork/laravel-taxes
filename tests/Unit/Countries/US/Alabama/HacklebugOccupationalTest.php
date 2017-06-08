<?php

namespace Appleton\Taxes\Countries\US\Alabama;

use Appleton\Taxes\Countries\US\Alabama\HacklebugOccupational;

class HacklebugOccupationalTest extends \TestCase
{
    public function testHacklebugOccupational()
    {
        $taxes = $this->app->make(HacklebugOccupational::class);

        $result = $taxes
            ->withEarnings(2300)
            ->compute();

        $this->assertSame(23.00, $result);
    }
}
