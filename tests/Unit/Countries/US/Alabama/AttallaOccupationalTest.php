<?php

namespace Appleton\Taxes\Countries\US\Alabama;

use Appleton\Taxes\Countries\US\Alabama\AttallaOccupational;

class AttallaOccupationalTest extends \TestCase
{
    public function testAttallaOccupational()
    {
        $taxes = $this->app->make(AttallaOccupational::class);

        $result = $taxes
            ->withEarnings(2300)
            ->compute();

        $this->assertSame(46.00, $result);
    }
}
