<?php

namespace Appleton\Taxes\Unit\Countries\US\Missouri;

use Appleton\Taxes\Classes\Taxes;
use Appleton\Taxes\Countries\US\Missouri\MissouriUnemployment\MissouriUnemployment;
use Carbon\Carbon;
use TestCase;

class MissouriUnemploymentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    public function testMissouriUnemployment(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.missouri'));
            $taxes->setWorkLocation($this->getLocation('us.missouri'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
        });

        // round(200.0 * .027, 2) = 5.4;
        $this->assertThat(5.4, self::identicalTo($results->getTax(MissouriUnemployment::class)));
    }

    public function testMissouriUnemployment_notMetWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.missouri'));
            $taxes->setWorkLocation($this->getLocation('us.missouri'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(11700);
        });

        // 11700 + 200 = 11900
        // 12000 wage base not met, all taxable
        // round(200.0 * .027, 2) = 5.4;
        $this->assertThat(5.4, self::identicalTo($results->getTax(MissouriUnemployment::class)));
    }

    public function testMissouriUnemployment_metAndExceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.missouri'));
            $taxes->setWorkLocation($this->getLocation('us.missouri'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(11900);
        });

        // 11900 + 200 = 12100
        // 100 over 12000 wage base so only 100 taxable
        // round(100.0 * .027, 2) = 2.7;
        $this->assertThat(2.7, self::identicalTo($results->getTax(MissouriUnemployment::class)));
    }

    public function testMissouriUnemployment_exceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.missouri'));
            $taxes->setWorkLocation($this->getLocation('us.missouri'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(12000);
        });

        // 12200 exceeds 12000 wage base, none taxable
        $this->assertThat(null, self::identicalTo($results->getTax(MissouriUnemployment::class)));
    }
}
