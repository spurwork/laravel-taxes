<?php

namespace Appleton\Taxes\Unit\Countries\US\RhodeIsland;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes;
use Appleton\Taxes\Countries\US\RhodeIsland\RhodeIslandUnemployment\RhodeIslandUnemployment;
use Carbon\Carbon;
use TestCase;

class RhodeIslandUnemploymentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    public function testRhodeIslandUnemployment(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.rhode_island'));
            $taxes->setWorkLocation($this->getLocation('us.rhode_island'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
        });

        // round(200.0 * .0117, 2) = 2.34;
        $this->assertThat(2.34, self::identicalTo($results->getTax(RhodeIslandUnemployment::class)));
    }

    public function testRhodeIslandUnemployment_notMetWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.rhode_island'));
            $taxes->setWorkLocation($this->getLocation('us.rhode_island'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(23300);
        });

        // 23300 + 200 = 23500
        // 23600 wage base not met, all taxable
        // round(200.0 * .0117, 2) = 2.34;
        $this->assertThat(2.34, self::identicalTo($results->getTax(RhodeIslandUnemployment::class)));
    }

    public function testRhodeIslandUnemployment_metAndExceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.rhode_island'));
            $taxes->setWorkLocation($this->getLocation('us.rhode_island'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(23500);
        });

        // 23500 + 200 = 23700
        // 100 over 23600 wage base so only 100 taxable
        // round(100.0 * .0117, 2) = 1.17;
        $this->assertThat(1.17, self::identicalTo($results->getTax(RhodeIslandUnemployment::class)));
    }

    public function testRhodeIslandUnemployment_exceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.rhode_island'));
            $taxes->setWorkLocation($this->getLocation('us.rhode_island'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(23600);
        });

        // 23800 exceeds 23600 wage base, none taxable
        $this->assertThat(null, self::identicalTo($results->getTax(RhodeIslandUnemployment::class)));
    }
}
