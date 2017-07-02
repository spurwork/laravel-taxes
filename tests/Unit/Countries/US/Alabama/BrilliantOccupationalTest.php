<?php

namespace Appleton\Taxes\Countries\US\Alabama\BrilliantOccupational;

class BrilliantOccupationalTest extends \TestCase
{
    public function testBrilliantOccupational()
    {
        $result = $this->app->makeWith(BrilliantOccupational::class, [
            'earnings' => 2300,
        ])->compute();

        $this->assertSame(23.00, $result);
    }
}
