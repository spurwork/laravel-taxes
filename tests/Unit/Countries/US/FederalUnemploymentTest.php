<?php

namespace Appleton\Taxes\Countries\US\FederalUnemployment;

use Appleton\Taxes\Countries\US;
use Appleton\Taxes\Countries\US\Alabama\AlabamaUnemployment\AlabamaUnemployment;
use Carbon\Carbon;

class FederalUnemploymentTest extends \TestCase
{
    public function testFederalUnemployment()
    {
        $result = $this->app->makeWith(FederalUnemployment::class, [
            'earnings' => 2300,
        ])->compute();

        $this->assertSame(138.0, $result);
    }

    public function testFederalUnemploymentWithCredit()
    {
        $result = $this->app->makeWith(FederalUnemployment::class, [
            'earnings' => 2300,
            'credit' => 0.01,
        ])->compute();

        $this->assertSame(115.00, $result);
    }

    public function testFederalUnemploymentWithStateCredit()
    {
        $result = $this->app->makeWith(FederalUnemployment::class, [
            'earnings' => 2300,
            'credit' => AlabamaUnemployment::getCredit(),
        ])->compute();

        $this->assertSame(13.80, $result);
    }

    public function testFederalUnemploymentMetWageBase()
    {
        $result = $this->app->makeWith(FederalUnemployment::class, [
            'earnings' => 2300,
            'ytd_earnings' => 7000,
        ])->compute();

        $this->assertSame(0.0, $result);
    }

    public function testCaseStudy1()
    {
        $result = $this->app->makeWith(FederalUnemployment::class, [
            'earnings' => 66.68,
            'credit' => AlabamaUnemployment::getCredit(),
        ])->compute();

        $this->assertSame(0.40, $result);
    }
}
