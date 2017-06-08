<?php

namespace Appleton\Taxes\Countries\US\Alabama;

use Appleton\Taxes\Countries\US\Alabama\FairfieldOccupational;

class FairfieldOccupationalTest extends \TestCase
{
    public function testFairfieldOccupational()
    {
        $taxes = $this->app->make(FairfieldOccupational::class);

        $result = $taxes
            ->withEarnings(2300)
            ->compute();

        $this->assertSame(23.00, $result);
    }
}
