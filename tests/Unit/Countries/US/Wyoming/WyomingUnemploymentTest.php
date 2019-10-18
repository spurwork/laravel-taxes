<?php

namespace Appleton\Taxes\Unit\Countries\US\Wyoming;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes;
use Appleton\Taxes\Countries\US\Wyoming\WyomingUnemployment\WyomingUnemployment;
use Carbon\Carbon;
use TestCase;

class WyomingUnemploymentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    public function testWyomingUnemployment(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.wyoming'));
            $taxes->setWorkLocation($this->getLocation('us.wyoming'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
        });

        // round(200.0 * .0122, 2) = 2.44;
        $this->assertThat(2.44, self::identicalTo($results->getTax(WyomingUnemployment::class)));
    }

    public function testWyomingUnemployment_notMetWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.wyoming'));
            $taxes->setWorkLocation($this->getLocation('us.wyoming'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(25100);
        });

        // 25100 + 200 = 25300
        // 25400 wage base not met, all taxable
        // round(200.0 * .0122, 2) = 2.44;
        $this->assertThat(2.44, self::identicalTo($results->getTax(WyomingUnemployment::class)));
    }

    public function testWyomingUnemployment_metAndExceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.wyoming'));
            $taxes->setWorkLocation($this->getLocation('us.wyoming'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(25300);
        });

        // 25300 + 200 = 25500
        // 100 over 25400 wage base so only 100 taxable
        // round(100.0 * .0122, 2) = 1.22;
        $this->assertThat(1.22, self::identicalTo($results->getTax(WyomingUnemployment::class)));
    }

    public function testWyomingUnemployment_exceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.wyoming'));
            $taxes->setWorkLocation($this->getLocation('us.wyoming'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(25400);
        });

        // 25600 exceeds 25400 wage base, none taxable
        $this->assertThat(null, self::identicalTo($results->getTax(WyomingUnemployment::class)));
    }
}
