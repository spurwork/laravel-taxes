<?php

namespace Appleton\Taxes\Countries\US\Alabama;

use Appleton\Taxes\Countries\US\Alabama\MidfieldOccupational;

class MidfieldOccupationalTest extends \TestCase
{
    public function testMidfieldOccupational()
    {
        $taxes = $this->app->make(MidfieldOccupational::class);

        $result = $taxes
            ->withEarnings(2300)
            ->compute();

        $this->assertSame(23.00, $result);
    }
}
