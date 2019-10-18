<?php

namespace Appleton\Taxes\Unit\Countries\US\Idaho;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes;
use Appleton\Taxes\Countries\US\Idaho\IdahoUnemployment\IdahoUnemployment;
use Carbon\Carbon;
use TestCase;

class IdahoUnemploymentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    public function testIdahoUnemployment(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.idaho'));
            $taxes->setWorkLocation($this->getLocation('us.idaho'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
        });

        // round(200.0 * .01, 2) = 2.0;
        $this->assertThat(2.0, self::identicalTo($results->getTax(IdahoUnemployment::class)));
    }

    public function testIdahoUnemployment_notMetWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.idaho'));
            $taxes->setWorkLocation($this->getLocation('us.idaho'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(39700);
        });

        // 39700 + 200 = 3990
        // 40000 wage base not met, all taxable
        // round(200.0 * .01, 2) = 2.0;
        $this->assertThat(2.0, self::identicalTo($results->getTax(IdahoUnemployment::class)));
    }

    public function testIdahoUnemployment_metAndExceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.idaho'));
            $taxes->setWorkLocation($this->getLocation('us.idaho'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(39900);
        });

        // 39900 + 200 = 40100
        // 100 over 40000 wage base so only 100 taxable
        // round(100.0 * .01, 2) = 1.0;
        $this->assertThat(1.0, self::identicalTo($results->getTax(IdahoUnemployment::class)));
    }

    public function testIdahoUnemployment_exceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.idaho'));
            $taxes->setWorkLocation($this->getLocation('us.idaho'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(40000);
        });

        // 40200 exceeds 40000 wage base, none taxable
        $this->assertThat(null, self::identicalTo($results->getTax(IdahoUnemployment::class)));
    }
}
