<?php

namespace Appleton\Taxes\Countries\US\Alabama\BirminghamOccupational;

class BirminghamOccupationalTest extends \TestCase
{
    public function testBirminghamOccupational()
    {
        $result = $this->app->makeWith(BirminghamOccupational::class, [
            'earnings' => 2300,
        ])->compute();

        $this->assertSame(23.00, $result);
    }

    public function testCaseStudy1()
    {
        $result = $this->app->makeWith(BirminghamOccupational::class, [
            'earnings' => 66.68,
        ])->compute();

        $this->assertSame(0.67, $result);
    }
}
