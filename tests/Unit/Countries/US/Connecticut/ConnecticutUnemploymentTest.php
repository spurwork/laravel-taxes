<?php

namespace Appleton\Taxes\Unit\Countries\US\Connecticut;

use Appleton\Taxes\Classes\Taxes;
use Appleton\Taxes\Countries\US\Connecticut\ConnecticutUnemployment\ConnecticutUnemployment;
use Carbon\Carbon;
use TestCase;

class ConnecticutUnemploymentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    public function testConnecticutUnemployment(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.connecticut'));
            $taxes->setWorkLocation($this->getLocation('us.connecticut'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
        });

        // round(200.0 * .034, 2) = 6.8;
        $this->assertThat(6.8, self::identicalTo($results->getTax(ConnecticutUnemployment::class)));
    }

    public function testConnecticutUnemploymentNotMetWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.connecticut'));
            $taxes->setWorkLocation($this->getLocation('us.connecticut'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(14200);
        });

        // 14200 + 200 = 14400
        // 15000 wage base not met, all taxable
        // round(200.0 * .034, 2) = 6.8;
        $this->assertThat(6.8, self::identicalTo($results->getTax(ConnecticutUnemployment::class)));
    }

    public function testConnecticutUnemploymentMetAndExceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.connecticut'));
            $taxes->setWorkLocation($this->getLocation('us.connecticut'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(14900);
        });

        // 14900 + 200 = 15100
        // 100 over 15000 wage base so only 100 taxable
        // round(100.0 * .034, 2) = 3.4;
        $this->assertThat(3.4, self::identicalTo($results->getTax(ConnecticutUnemployment::class)));
    }

    public function testConnecticutUnemploymentExceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.connecticut'));
            $taxes->setWorkLocation($this->getLocation('us.connecticut'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(15000);
        });

        // 15200 exceeds 15000 wage base, none taxable
        $this->assertThat(null, self::identicalTo($results->getTax(ConnecticutUnemployment::class)));
    }
}
