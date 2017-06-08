<?php

namespace Appleton\Taxes\Countries\US\Alabama;

use Appleton\Taxes\Countries\US\Alabama\AlabamaUnemployment;

class AlabamaUnemploymentTest extends \TestCase
{
    public function testAlabamaUnemployment()
    {
        $taxes = $this->app->make(AlabamaUnemployment::class);

        $result = $taxes
            ->withEarnings(2300)
            ->withYtdEarnings(0)
            ->compute();

        $this->assertSame(62.10, $result);
    }

    public function testAlabamaUnemploymentWithTaxRate()
    {
        $taxes = $this->app->make(AlabamaUnemployment::class);

        $result = $taxes
            ->withEarnings(2300)
            ->withYtdEarnings(0)
            ->withTaxRate(0.024)
            ->compute();

        $this->assertSame(55.20, $result);
    }
    public function testAlabamaUnemploymentMetWageBase()
    {
        $taxes = $this->app->make(AlabamaUnemployment::class);

        $result = $taxes
            ->withEarnings(2300)
            ->withYtdEarnings(AlabamaUnemployment::WAGE_BASE)
            ->compute();

        $this->assertSame(0.0, $result);
    }

    public function testCaseStudy1()
    {
        $taxes = $this->app->make(AlabamaUnemployment::class);

        $result = $taxes
            ->withEarnings(66.68)
            ->withYtdEarnings(0)
            ->withTaxRate(0.019)
            ->compute();

        $this->assertSame(1.27, $result);
    }
}
