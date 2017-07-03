<?php

namespace Appleton\Taxes\Countries\US\Alabama\BirminghamOccupational;

class BirminghamOccupationalTest extends \TestCase
{
    public function testBirminghamOccupational()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation(33.5207, -86.8025);
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(23.00, $results->getTax(BirminghamOccupational::class));
    }

    public function testCaseStudy1()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation(33.5207, -86.8025);
            $taxes->setUser($this->user);
            $taxes->setEarnings(66.68);
        });

        $this->assertSame(0.67, $results->getTax(BirminghamOccupational::class));
    }
}
