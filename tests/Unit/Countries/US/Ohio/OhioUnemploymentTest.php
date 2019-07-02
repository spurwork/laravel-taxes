<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Classes\Taxes;
use Appleton\Taxes\Countries\US\Ohio\OhioUnemployment\OhioUnemployment;
use Carbon\Carbon;
use TestCase;

class OhioUnemploymentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    public function testOhioUnemployment(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio'));
            $taxes->setWorkLocation($this->getLocation('us.ohio'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
        });

        // round(200.0 * .027, 2) = 5.4;
        $this->assertThat(5.4, self::identicalTo($results->getTax(OhioUnemployment::class)));
    }

    public function testOhioUnemployment_notMetWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio'));
            $taxes->setWorkLocation($this->getLocation('us.ohio'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(9200);
        });

        // 9200 + 200 = 9400
        // 9500 wage base not met, all taxable
        // round(200.0 * .027, 2) = 5.4;
        $this->assertThat(5.4, self::identicalTo($results->getTax(OhioUnemployment::class)));
    }

    public function testOhioUnemployment_metAndExceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio'));
            $taxes->setWorkLocation($this->getLocation('us.ohio'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(9400);
        });

        // 9400 + 200 = 9600
        // 100 over 9500 wage base so only 200 taxable
        // round(100.0 * .027, 2) = 2.7;
        $this->assertThat(2.7, self::identicalTo($results->getTax(OhioUnemployment::class)));
    }

    public function testOhioUnemployment_exceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio'));
            $taxes->setWorkLocation($this->getLocation('us.ohio'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(9500);
        });

        // 9700 exceeds 9500 wage base, none taxable
        $this->assertThat(null, self::identicalTo($results->getTax(OhioUnemployment::class)));
    }
}
