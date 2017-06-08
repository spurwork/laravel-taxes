<?php

namespace Appleton\Taxes\Countries\US\Alabama;

use Appleton\Taxes\Countries\US\Alabama\GuinOccupational;

class GuinOccupationalTest extends \TestCase
{
    public function testGuinOccupational()
    {
        $taxes = $this->app->make(GuinOccupational::class);

        $result = $taxes
            ->withEarnings(2300)
            ->compute();

        $this->assertSame(23.00, $result);
    }
}
