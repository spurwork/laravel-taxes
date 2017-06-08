<?php

namespace Appleton\Taxes\Countries\US\Alabama;

use Appleton\Taxes\Countries\US\Alabama\SulligentOccupational;

class SulligentOccupationalTest extends \TestCase
{
    public function testSulligentOccupational()
    {
        $taxes = $this->app->make(SulligentOccupational::class);

        $result = $taxes
            ->withEarnings(2300)
            ->compute();

        $this->assertSame(23.00, $result);
    }
}
