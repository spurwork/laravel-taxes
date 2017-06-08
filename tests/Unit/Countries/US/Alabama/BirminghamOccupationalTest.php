<?php

namespace Appleton\Taxes\Countries\US\Alabama;

use Appleton\Taxes\Countries\US\Alabama\BirminghamOccupational;

class BirminghamOccupationalTest extends \TestCase
{
    public function testBirminghamOccupationalt()
    {
        $taxes = $this->app->make(BirminghamOccupational::class);

        $result = $taxes
            ->withEarnings(2300)
            ->compute();

        $this->assertSame(23.00, $result);
    }

    public function testCaseStudy1()
    {
        $taxes = $this->app->make(BirminghamOccupational::class);

        $result = $taxes
            ->withEarnings(66.68)
            ->compute();

        $this->assertSame(0.67, $result);
    }
}
