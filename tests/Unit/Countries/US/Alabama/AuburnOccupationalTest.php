<?php

namespace Appleton\Taxes\Countries\US\Alabama;

use Appleton\Taxes\Countries\US\Alabama\AuburnOccupational;

class AuburnOccupationalTest extends \TestCase
{
    public function testAuburnOccupational()
    {
        $result = $this->app->makeWith(AuburnOccupational::class, [
            'earnings' => 2300,
        ])->compute();

        $this->assertSame(23.00, $result);
    }
}
