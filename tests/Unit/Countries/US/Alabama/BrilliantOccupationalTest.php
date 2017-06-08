<?php

namespace Appleton\Taxes\Countries\US\Alabama;

use Appleton\Taxes\Countries\US\Alabama\BrilliantOccupational;

class BrilliantOccupationalTest extends \TestCase
{
    public function testBrilliantOccupational()
    {
        $taxes = $this->app->make(BrilliantOccupational::class);

        $result = $taxes
            ->withEarnings(2300)
            ->compute();

        $this->assertSame(23.00, $result);
    }
}
