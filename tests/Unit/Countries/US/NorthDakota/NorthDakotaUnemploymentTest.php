<?php

namespace Appleton\Taxes\Unit\Countries\US\NorthDakota;

use Appleton\Taxes\Classes\Taxes;
use Appleton\Taxes\Countries\US\NorthDakota\NorthDakotaUnemployment\NorthDakotaUnemployment;
use Carbon\Carbon;
use TestCase;

class NorthDakotaUnemploymentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    public function testNorthDakotaUnemployment(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.north_dakota'));
            $taxes->setWorkLocation($this->getLocation('us.north_dakota'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
        });

        // round(200.0 * .0121, 2) = 2.42;
        $this->assertThat(2.42, self::identicalTo($results->getTax(NorthDakotaUnemployment::class)));
    }

    public function testNorthDakotaUnemployment_notMetWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.north_dakota'));
            $taxes->setWorkLocation($this->getLocation('us.north_dakota'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(13700);
        });

        // 36100 + 200 = 36300
        // 36400 wage base not met, all taxable
        // round(200.0 * .0121, 2) = 2.42;
        $this->assertThat(2.42, self::identicalTo($results->getTax(NorthDakotaUnemployment::class)));
    }

    public function testNorthDakotaUnemployment_metAndExceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.north_dakota'));
            $taxes->setWorkLocation($this->getLocation('us.north_dakota'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(36300);
        });

        // 36300 + 200 = 36500
        // 100 over 36400 wage base so only 100 taxable
        // round(100.0 * .0121, 2) = 1.21;
        $this->assertThat(1.21, self::identicalTo($results->getTax(NorthDakotaUnemployment::class)));
    }

    public function testNorthDakotaUnemployment_exceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.north_dakota'));
            $taxes->setWorkLocation($this->getLocation('us.north_dakota'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(36400);
        });

        // 36600 exceeds 36400 wage base, none taxable
        $this->assertThat(null, self::identicalTo($results->getTax(NorthDakotaUnemployment::class)));
    }
}
