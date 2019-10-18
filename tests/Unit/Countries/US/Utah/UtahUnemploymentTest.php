<?php

namespace Appleton\Taxes\Unit\Countries\US\Utah;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes;
use Appleton\Taxes\Countries\US\Utah\UtahUnemployment\UtahUnemployment;
use Carbon\Carbon;
use TestCase;

class UtahUnemploymentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    public function testUtahUnemployment(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.utah'));
            $taxes->setWorkLocation($this->getLocation('us.utah'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
        });

        // round(200.0 * .03, 2) = 6.0;
        $this->assertThat(6.0, self::identicalTo($results->getTax(UtahUnemployment::class)));
    }

    public function testUtahUnemployment_notMetWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.utah'));
            $taxes->setWorkLocation($this->getLocation('us.utah'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(35000);
        });

        // 35000 + 200 = 35200
        // 35300 wage base not met, all taxable
        // round(200.0 * .03, 2) = 6.0;
        $this->assertThat(6.0, self::identicalTo($results->getTax(UtahUnemployment::class)));
    }

    public function testUtahUnemployment_metAndExceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.utah'));
            $taxes->setWorkLocation($this->getLocation('us.utah'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(35200);
        });

        // 35200 + 200 = 35400
        // 100 over 35300 wage base so only 100 taxable
        // round(100.0 * .03, 2) = 3.0;
        $this->assertThat(3.0, self::identicalTo($results->getTax(UtahUnemployment::class)));
    }

    public function testUtahUnemployment_exceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.utah'));
            $taxes->setWorkLocation($this->getLocation('us.utah'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(35300);
        });

        // 35500 exceeds 35300 wage base, none taxable
        $this->assertThat(null, self::identicalTo($results->getTax(UtahUnemployment::class)));
    }
}
