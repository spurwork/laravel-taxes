<?php

namespace Appleton\Taxes\Unit\Countries\US\Minnesota;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes;
use Appleton\Taxes\Countries\US\Minnesota\MinnesotaUnemployment\MinnesotaUnemployment;
use Carbon\Carbon;
use TestCase;

class MinnesotaUnemploymentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    public function testMinnesotaUnemployment(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.minnesota'));
            $taxes->setWorkLocation($this->getLocation('us.minnesota'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
        });

        // round(200.0 * .01, 2) = 2.0;
        $this->assertThat(2.0, self::identicalTo($results->getTax(MinnesotaUnemployment::class)));
    }

    public function testMinnesotaUnemployment_notMetWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.minnesota'));
            $taxes->setWorkLocation($this->getLocation('us.minnesota'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(34300);
        });

        // 34300 + 200 = 34500
        // 34600 wage base not met, all taxable
        // round(200.0 * .01, 2) = 2.0;
        $this->assertThat(2.0, self::identicalTo($results->getTax(MinnesotaUnemployment::class)));
    }

    public function testMinnesotaUnemployment_metAndExceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.minnesota'));
            $taxes->setWorkLocation($this->getLocation('us.minnesota'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(34500);
        });

        // 34500 + 200 = 34700
        // 100 over 34600 wage base so only 100 taxable
        // round(100.0 * .01, 2) = 1.0;
        $this->assertThat(1.0, self::identicalTo($results->getTax(MinnesotaUnemployment::class)));
    }

    public function testMinnesotaUnemployment_exceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.minnesota'));
            $taxes->setWorkLocation($this->getLocation('us.minnesota'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(34600);
        });

        // 34800 exceeds 34600 wage base, none taxable
        $this->assertThat(null, self::identicalTo($results->getTax(MinnesotaUnemployment::class)));
    }
}
