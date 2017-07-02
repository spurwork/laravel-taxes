<?php

namespace Appleton\Taxes\Countries\US\Alabama;

use Appleton\Taxes\Countries\US\Alabama\HamiltonOccupational;

class HamiltonOccupationalTest extends \TestCase
{
    public function testHamiltonOccupational()
    {
        $result = $this->app->makeWith(HamiltonOccupational::class, [
            'earnings' => 2300,
        ])->compute();

        $this->assertSame(23.00, $result);
    }
}
