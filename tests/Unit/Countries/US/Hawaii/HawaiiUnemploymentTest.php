<?php

namespace Appleton\Taxes\Unit\Countries\US\Hawaii;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes;
use Appleton\Taxes\Countries\US\Hawaii\HawaiiUnemployment\HawaiiUnemployment;
use Carbon\Carbon;
use TestCase;

class HawaiiUnemploymentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    public function testHawaiiUnemployment(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.hawaii'));
            $taxes->setWorkLocation($this->getLocation('us.hawaii'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
        });

        // round(200.0 * .024, 2) = 4.8;
        $this->assertThat(4.8, self::identicalTo($results->getTax(HawaiiUnemployment::class)));
    }

    public function testHawaiiUnemployment_notMetWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.hawaii'));
            $taxes->setWorkLocation($this->getLocation('us.hawaii'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(46500);
        });

        // 46500 + 200 = 46700
        // 46800 wage base not met, all taxable
        // round(200.0 * .024, 2) = 4.8;
        $this->assertThat(4.8, self::identicalTo($results->getTax(HawaiiUnemployment::class)));
    }

    public function testHawaiiUnemployment_metAndExceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.hawaii'));
            $taxes->setWorkLocation($this->getLocation('us.hawaii'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(46700);
        });

        // 46700 + 200 = 46900
        // 100 over 46800 wage base so only 100 taxable
        // round(100.0 * .024, 2) = 2.4;
        $this->assertThat(2.4, self::identicalTo($results->getTax(HawaiiUnemployment::class)));
    }

    public function testHawaiiUnemployment_exceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.hawaii'));
            $taxes->setWorkLocation($this->getLocation('us.hawaii'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(46800);
        });

        // 47000 exceeds 46800 wage base, none taxable
        $this->assertThat(null, self::identicalTo($results->getTax(HawaiiUnemployment::class)));
    }
}
