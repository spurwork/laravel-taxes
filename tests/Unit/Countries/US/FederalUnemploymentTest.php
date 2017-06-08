<?php

namespace Appleton\Taxes\Countries\US;

use Appleton\Taxes\Countries\US;
use Appleton\Taxes\Countries\US\Alabama\AlabamaUnemployment;

class FederalUnemploymentTest extends \TestCase
{
    public function testFederalUnemployment()
    {
        $taxes = $this->app->make(FederalUnemployment::class);

        $result = $taxes
            ->withEarnings(2300)
            ->withYtdEarnings(0)
            ->compute();

        $this->assertSame(138.0, $result);
    }

    public function testFederalUnemploymentWithCredit()
    {
        $taxes = $this->app->make(FederalUnemployment::class);

        $result = $taxes
            ->withEarnings(2300)
            ->withYtdEarnings(0)
            ->withCredit(0.01)
            ->compute();

        $this->assertSame(115.00, $result);
    }

    public function testFederalUnemploymentWithStateCredit()
    {
        $taxes = $this->app->make(FederalUnemployment::class);

        $result = $taxes
            ->withEarnings(2300)
            ->withYtdEarnings(0)
            ->withCredit(AlabamaUnemployment::FUTA_CREDIT)
            ->compute();

        $this->assertSame(13.80, $result);
    }

    public function testFederalUnemploymentMetWageBase()
    {
        $taxes = $this->app->make(FederalUnemployment::class);

        $result = $taxes
            ->withEarnings(2300)
            ->withYtdEarnings(FederalUnemployment::WAGE_BASE)
            ->compute();

        $this->assertSame(0.0, $result);
    }

    public function testCaseStudy1()
    {
        $taxes = $this->app->make(FederalUnemployment::class);

        $result = $taxes
            ->withEarnings(66.68)
            ->withYtdEarnings(0)
            ->withCredit(AlabamaUnemployment::FUTA_CREDIT)
            ->compute();

        $this->assertSame(0.40, $result);
    }
}
