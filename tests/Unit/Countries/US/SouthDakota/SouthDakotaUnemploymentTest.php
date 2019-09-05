<?php

namespace Appleton\Taxes\Unit\Countries\US\SouthDakota;

use Appleton\Taxes\Classes\Taxes;
use Appleton\Taxes\Countries\US\SouthDakota\SouthDakotaUnemployment\SouthDakotaUnemployment;
use Carbon\Carbon;
use TestCase;

class SouthDakotaUnemploymentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    public function testSouthDakotaUnemployment(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.south_dakota'));
            $taxes->setWorkLocation($this->getLocation('us.south_dakota'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
        });

        // round(200.0 * .012, 2) = 2.4;
        $this->assertThat(2.4, self::identicalTo($results->getTax(SouthDakotaUnemployment::class)));
    }

    public function testSouthDakotaUnemploymentNotMetWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.south_dakota'));
            $taxes->setWorkLocation($this->getLocation('us.south_dakota'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(14700);
        });

        // 14700 + 200 = 14900
        // 15000 wage base not met, all taxable
        // round(200.0 * .012, 2) = 2.4;
        $this->assertThat(2.4, self::identicalTo($results->getTax(SouthDakotaUnemployment::class)));
    }

    public function testSouthDakotaUnemploymentMetAndExceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.south_dakota'));
            $taxes->setWorkLocation($this->getLocation('us.south_dakota'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(14900);
        });

        // 14900 + 200 = 15100
        // 100 over 15000 wage base so only 100 taxable
        // round(100.0 * .012, 2) = 1.2;
        $this->assertThat(1.2, self::identicalTo($results->getTax(SouthDakotaUnemployment::class)));
    }

    public function testSouthDakotaUnemploymentExceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.south_dakota'));
            $taxes->setWorkLocation($this->getLocation('us.south_dakota'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(15000);
        });

        // 15200 exceeds 15000 wage base, none taxable
        $this->assertThat(null, self::identicalTo($results->getTax(SouthDakotaUnemployment::class)));
    }
}
