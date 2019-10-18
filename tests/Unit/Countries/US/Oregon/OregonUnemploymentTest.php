<?php

namespace Appleton\Taxes\Unit\Countries\US\Oregon;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes;
use Appleton\Taxes\Countries\US\Oregon\OregonUnemployment\OregonUnemployment;
use Carbon\Carbon;
use TestCase;

class OregonUnemploymentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-07-10'));
    }

    public function testOregonUnemployment(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.oregon'));
            $taxes->setWorkLocation($this->getLocation('us.oregon'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
        });

        // round(200.0 * .024, 2) = 4.8;
        $this->assertThat(4.8, self::identicalTo($results->getTax(OregonUnemployment::class)));
    }

    public function testOregonUnemployment_notMetWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.oregon'));
            $taxes->setWorkLocation($this->getLocation('us.oregon'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(40300);
        });

        // 40300 + 200 = 40500
        // 40600 wage base not met, all taxable
        // round(200.0 * .024, 2) = 4.8;
        $this->assertThat(4.8, self::identicalTo($results->getTax(OregonUnemployment::class)));
    }

    public function testOregonUnemployment_metAndExceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.oregon'));
            $taxes->setWorkLocation($this->getLocation('us.oregon'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(40500);
        });

        // 40500 + 200 = 40700
        // 100 over 40600 wage base so only 100 taxable
        // round(100.0 * .024, 2) = 2.4;
        $this->assertThat(2.4, self::identicalTo($results->getTax(OregonUnemployment::class)));
    }

    public function testOregonUnemployment_exceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.oregon'));
            $taxes->setWorkLocation($this->getLocation('us.oregon'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(40600);
        });

        // 40800 exceeds 40600 wage base, none taxable
        $this->assertThat(null, self::identicalTo($results->getTax(OregonUnemployment::class)));
    }
}
