<?php

namespace Appleton\Taxes\Countries\US\Alabama\GuinOccupational;

class GuinOccupationalTest extends \TestCase
{
    public function testGuinOccupational()
    {
        $result = $this->app->makeWith(GuinOccupational::class, [
            'earnings' => 2300,
        ])->compute();

        $this->assertSame(23.00, $result);
    }
}
