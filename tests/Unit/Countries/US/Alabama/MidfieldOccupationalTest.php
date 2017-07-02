<?php

namespace Appleton\Taxes\Countries\US\Alabama\MidfieldOccupational;

class MidfieldOccupationalTest extends \TestCase
{
    public function testMidfieldOccupational()
    {
        $result = $this->app->makeWith(MidfieldOccupational::class, [
            'earnings' => 2300,
        ])->compute();

        $this->assertSame(23.00, $result);
    }
}
