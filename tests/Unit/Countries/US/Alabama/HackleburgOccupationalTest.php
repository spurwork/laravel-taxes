<?php

namespace Appleton\Taxes\Countries\US\Alabama;

use Appleton\Taxes\Countries\US\Alabama\HackleburgOccupational;

class HackleburgOccupationalTest extends \TestCase
{
    public function testHackleburgOccupational()
    {
        $taxes = $this->app->make(HackleburgOccupational::class);

        $result = $taxes
            ->withEarnings(2300)
            ->compute();

        $this->assertSame(23.00, $result);
    }
}
