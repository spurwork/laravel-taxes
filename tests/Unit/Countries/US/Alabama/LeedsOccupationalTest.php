<?php

namespace Appleton\Taxes\Countries\US\Alabama;

use Appleton\Taxes\Countries\US\Alabama\LeedsOccupational;

class LeedsOccupationalTest extends \TestCase
{
    public function testLeedsOccupational()
    {
        $result = $this->app->makeWith(LeedsOccupational::class, [
            'earnings' => 2300,
        ])->compute();

        $this->assertSame(23.00, $result);
    }
}
