<?php

namespace Appleton\Taxes\Countries\US\Alabama;

use Appleton\Taxes\Countries\US\Alabama\AlabamaUnemployment;

class AlabamaUnemploymentTest extends \TestCase
{
    public function testAlabamaUnemployment()
    {
        $result = $this->app->makeWith(AlabamaUnemployment::class, [
            'earnings' => 2300,
        ])->compute();

        $this->assertSame(62.10, $result);
    }

    public function testAlabamaUnemploymentWithTaxRate()
    {
        $result = $this->app->makeWith(AlabamaUnemployment::class, [
            'earnings' => 2300,
            'tax_rate' => 0.024,
        ])->compute();

        $this->assertSame(55.20, $result);
    }

    public function testAlabamaUnemploymentMetWageBase()
    {
        $result = $this->app->makeWith(AlabamaUnemployment::class, [
            'earnings' => 2300,
            'ytd_earnings' => AlabamaUnemployment::WAGE_BASE,
        ])->compute();

        $this->assertSame(0.0, $result);
    }

    public function testCaseStudy1()
    {
        $result = $this->app->makeWith(AlabamaUnemployment::class, [
            'earnings' => 66.68,
            'tax_rate' => 0.019
        ])->compute();

        $this->assertSame(1.27, $result);
    }
}
