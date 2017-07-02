<?php

namespace Appleton\Taxes\Countries\US\Alabama;

use Appleton\Taxes\Countries\US\Alabama\OpelikaOccupational;

class OpelikaOccupationalTest extends \TestCase
{
    public function testOpelikaOccupational()
    {
        $result = $this->app->makeWith(OpelikaOccupational::class, [
            'earnings' => 2300,
        ])->compute();

        $this->assertSame(34.5, $result);
    }
}
