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

        // round(200.0 * .015, 2) = 3.0;
        $this->assertThat(3, self::identicalTo($results->getTax(OhioUnemployment::class)));
    }

    public function testOhioUnemployment_notMetWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio'));
            $taxes->setWorkLocation($this->getLocation('us.ohio'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(17900);
        });

        // 17900 + 200 = 18050
        // 18100 wage base not met, all taxable
        // round(200.0 * .015, 2) = 3;
        $this->assertThat(3, self::identicalTo($results->getTax(OhioUnemployment::class)));
    }

    public function testOhioUnemployment_metAndExceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio'));
            $taxes->setWorkLocation($this->getLocation('us.ohio'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(18000);
        });

        // 18000 + 200 = 18200
        // 100 over 18100 wage base so only 200 taxable
        // round(100.0 * .015, 2) = 1.5;
        $this->assertThat(2, self::identicalTo($results->getTax(OhioUnemployment::class)));
    }

    public function testOhioUnemployment_exceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio'));
            $taxes->setWorkLocation($this->getLocation('us.ohio'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(18200);
        });

        // 18500 exceeds 18100 wage base, none taxable
        $this->assertThat(0, self::identicalTo($results->getTax(OhioUnemployment::class)));
    }
}
