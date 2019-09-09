<?php

namespace Appleton\Taxes\Unit\Countries\US\NewHampshire;

use Appleton\Taxes\Classes\Taxes;
use Appleton\Taxes\Countries\US\NewHampshire\NewHampshireUnemployment\NewHampshireUnemployment;
use Carbon\Carbon;
use TestCase;

class NewHampshireUnemploymentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    public function testNewHampshireUnemployment(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.new_hampshire'));
            $taxes->setWorkLocation($this->getLocation('us.new_hampshire'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
        });

        // round(200.0 * .012, 2) = 2.4;
        $this->assertThat(2.4, self::identicalTo($results->getTax(NewHampshireUnemployment::class)));
    }

    public function testNewHampshireUnemploymentNotMetWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.new_hampshire'));
            $taxes->setWorkLocation($this->getLocation('us.new_hampshire'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(13700);
        });

        // 13700 + 200 = 13900
        // 14000 wage base not met, all taxable
        // round(200.0 * .012, 2) = 2.4;
        $this->assertThat(2.4, self::identicalTo($results->getTax(NewHampshireUnemployment::class)));
    }

    public function testNewHampshireUnemploymentMetAndExceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.new_hampshire'));
            $taxes->setWorkLocation($this->getLocation('us.new_hampshire'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(13900);
        });

        // 13900 + 200 = 14100
        // 100 over 14000 wage base so only 100 taxable
        // round(100.0 * .012, 2) = 1.2;
        $this->assertThat(1.2, self::identicalTo($results->getTax(NewHampshireUnemployment::class)));
    }

    public function testNewHampshireUnemploymentExceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.new_hampshire'));
            $taxes->setWorkLocation($this->getLocation('us.new_hampshire'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(14000);
        });

        // 14200 exceeds 14000 wage base, none taxable
        $this->assertThat(null, self::identicalTo($results->getTax(NewHampshireUnemployment::class)));
    }
}
