<?php

namespace Appleton\Taxes\Unit\Countries\US\Iowa;

use Appleton\Taxes\Classes\Taxes;
use Appleton\Taxes\Countries\US\Iowa\IowaUnemployment\IowaUnemployment;
use Carbon\Carbon;
use TestCase;

class IowaUnemploymentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    public function testIowaUnemployment(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.iowa'));
            $taxes->setWorkLocation($this->getLocation('us.iowa'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
        });

        // round(200.0 * .01, 2) = 2.0;
        $this->assertThat(2.0, self::identicalTo($results->getTax(IowaUnemployment::class)));
    }

    public function testIowaUnemployment_notMetWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.iowa'));
            $taxes->setWorkLocation($this->getLocation('us.iowa'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(13700);
        });

        // 30300 + 200 = 30500
        // 30600 wage base not met, all taxable
        // round(200.0 * .01, 2) = 2.0;
        $this->assertThat(2.0, self::identicalTo($results->getTax(IowaUnemployment::class)));
    }

    public function testIowaUnemployment_metAndExceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.iowa'));
            $taxes->setWorkLocation($this->getLocation('us.iowa'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(30500);
        });

        // 30500 + 200 = 30700
        // 100 over 30600 wage base so only 100 taxable
        // round(100.0 * .01, 2) = 1.0;
        $this->assertThat(1.0, self::identicalTo($results->getTax(IowaUnemployment::class)));
    }

    public function testIowaUnemployment_exceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.iowa'));
            $taxes->setWorkLocation($this->getLocation('us.iowa'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(30600);
        });

        // 30800 exceeds 30600 wage base, none taxable
        $this->assertThat(null, self::identicalTo($results->getTax(IowaUnemployment::class)));
    }
}
