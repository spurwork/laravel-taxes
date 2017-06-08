<?php

namespace Appleton\Taxes\Countries\US\Alabama;

use Appleton\Taxes\Countries\US\Alabama\RedBayOccupational;

class RedBayOccupationalTest extends \TestCase
{
    public function testRedBayOccupational()
    {
        $taxes = $this->app->make(RedBayOccupational::class);

        $result = $taxes
            ->withEarnings(2300)
            ->compute();

        $this->assertSame(11.5, $result);
    }
}
