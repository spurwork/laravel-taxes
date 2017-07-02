<?php

namespace Appleton\Taxes\Countries\US\Alabama\HackleburgOccupational;

class HackleburgOccupationalTest extends \TestCase
{
    public function testHackleburgOccupational()
    {
        $result = $this->app->makeWith(HackleburgOccupational::class, [
            'earnings' => 2300,
        ])->compute();

        $this->assertSame(23.00, $result);
    }
}
