<?php

namespace Appleton\Taxes\Countries\US\Alabama;

use Appleton\Taxes\Countries\US\Alabama\LynnOccupational;

class LynnOccupationalTest extends \TestCase
{
    public function testLynnOccupational()
    {
        $taxes = $this->app->make(LynnOccupational::class);

        $result = $taxes
            ->withEarnings(2300)
            ->compute();

        $this->assertSame(23.00, $result);
    }
}
