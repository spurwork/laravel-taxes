<?php

namespace Appleton\Taxes\Countries\US\FederalUnemployment;

use Carbon\Carbon;

class FederalUnemploymentTest extends \TestCase
{
    public function testFederalUnemployment()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation(38.9072, -77.0369);
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(138.0, $results->getTax(FederalUnemployment::class));
    }

    public function testFederalUnemploymentWithStateCredit()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation(32.3182, -86.9023);
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(13.80, $results->getTax(FederalUnemployment::class));
    }

    public function testFederalUnemploymentMetWageBase()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation(32.3182, -86.9023);
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
            $taxes->setYtdEarnings(7000);
        });

        $this->assertSame(0.0, $results->getTax(FederalUnemployment::class));
    }

    public function testCaseStudy1()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation(32.3182, -86.9023);
            $taxes->setUser($this->user);
            $taxes->setEarnings(66.68);
        });

        $this->assertSame(0.40, $results->getTax(FederalUnemployment::class));
    }
}
