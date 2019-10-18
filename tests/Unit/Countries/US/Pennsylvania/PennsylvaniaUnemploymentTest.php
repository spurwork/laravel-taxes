<?php

namespace Appleton\Taxes\Unit\Countries\US\Pennsylvania;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes;
use Appleton\Taxes\Countries\US\Pennsylvania\PennsylvaniaUnemployment\PennsylvaniaUnemployment;
use Carbon\Carbon;
use TestCase;

class PennsylvaniaUnemploymentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    public function testPennsylvaniaUnemployment(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.pennsylvania'));
            $taxes->setWorkLocation($this->getLocation('us.pennsylvania'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
        });

        // round(200.0 * .03689, 2) = 7.38;
        $this->assertThat(7.38, self::identicalTo($results->getTax(PennsylvaniaUnemployment::class)));
    }

    public function testPennsylvaniaUnemployment_notMetWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.pennsylvania'));
            $taxes->setWorkLocation($this->getLocation('us.pennsylvania'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(9700);
        });

        // 9700 + 200 = 9900
        // 10000 wage base not met, all taxable
        // round(200.0 * .03689, 2) = 7.38;
        $this->assertThat(7.38, self::identicalTo($results->getTax(PennsylvaniaUnemployment::class)));
    }

    public function testPennsylvaniaUnemployment_metAndExceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.pennsylvania'));
            $taxes->setWorkLocation($this->getLocation('us.pennsylvania'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(9900);
        });

        // 9900 + 200 = 9600
        // 100 over 10000 wage base so only 100 taxable
        // round(100.0 * .03689, 2) = 3.69;
        $this->assertThat(3.69, self::identicalTo($results->getTax(PennsylvaniaUnemployment::class)));
    }

    public function testPennsylvaniaUnemployment_exceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.pennsylvania'));
            $taxes->setWorkLocation($this->getLocation('us.pennsylvania'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(10000);
        });

        // 10200 exceeds 10000 wage base, none taxable
        $this->assertThat(null, self::identicalTo($results->getTax(PennsylvaniaUnemployment::class)));
    }
}
