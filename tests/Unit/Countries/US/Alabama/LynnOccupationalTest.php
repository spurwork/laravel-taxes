<?php

namespace Appleton\Taxes\Countries\US\Alabama;

use Appleton\Taxes\Countries\US\Alabama\LynnOccupational;

class LynnOccupationalTest extends \TestCase
{
    public function testLynnOccupational()
    {
        $result = $this->app->makeWith(LynnOccupational::class, [
            'earnings' => 2300,
        ])->compute();

        $this->assertSame(23.00, $result);
    }
}
