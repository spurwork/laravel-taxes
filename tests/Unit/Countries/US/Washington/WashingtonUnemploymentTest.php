<?php

namespace Appleton\Taxes\Unit\Countries\US\Washington;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes;
use Appleton\Taxes\Countries\US\Washington\WashingtonUnemployment\WashingtonUnemployment;
use Carbon\Carbon;
use TestCase;

class WashingtonUnemploymentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    public function testWashingtonUnemployment(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.washington'));
            $taxes->setWorkLocation($this->getLocation('us.washington'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
        });

        // round(200.0 * .015, 2) = 3.0;
        $this->assertThat(3.0, self::identicalTo($results->getTax(WashingtonUnemployment::class)));
    }

    public function testWashingtonUnemploymentNotMetWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.washington'));
            $taxes->setWorkLocation($this->getLocation('us.washington'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(49500);
        });

        // 49500 + 200 = 49700
        // 49800 wage base not met, all taxable
        // round(200.0 * .015, 2) = 3.0;
        $this->assertThat(3.0, self::identicalTo($results->getTax(WashingtonUnemployment::class)));
    }

    public function testWashingtonUnemploymentMetAndExceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.washington'));
            $taxes->setWorkLocation($this->getLocation('us.washington'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(49700);
        });

        // 49700 + 200 = 49900
        // 100 over 49800 wage base so only 100 taxable
        // round(100.0 * .015, 2) = 1.5;
        $this->assertThat(1.5, self::identicalTo($results->getTax(WashingtonUnemployment::class)));
    }

    public function testWashingtonUnemploymentExceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.washington'));
            $taxes->setWorkLocation($this->getLocation('us.washington'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(49800);
        });

        // 50000 exceeds 49800 wage base, none taxable
        $this->assertThat(null, self::identicalTo($results->getTax(WashingtonUnemployment::class)));
    }
}
