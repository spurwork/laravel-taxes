<?php

namespace Appleton\Taxes\Countries\US\Alabama;

use Appleton\Taxes\Countries\US\Alabama\TuskegeeOccupational;

class TuskegeeOccupationalTest extends \TestCase
{
    public function testTuskegeeOccupational()
    {
        $taxes = $this->app->make(TuskegeeOccupational::class);

        $result = $taxes
            ->withEarnings(2300)
            ->compute();

        $this->assertSame(46.00, $result);
    }
}
