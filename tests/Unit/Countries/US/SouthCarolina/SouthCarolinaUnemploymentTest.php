<?php

namespace Appleton\Taxes\Unit\Countries\US\SouthCarolina;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes;
use Appleton\Taxes\Countries\US\SouthCarolina\SouthCarolinaUnemployment\SouthCarolinaUnemployment;
use Carbon\Carbon;
use TestCase;

class SouthCarolinaUnemploymentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    public function testSouthCarolinaUnemployment(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.south_carolina'));
            $taxes->setWorkLocation($this->getLocation('us.south_carolina'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
        });

        // round(200.0 * .0087, 2) = 1.74;
        $this->assertThat(1.74, self::identicalTo($results->getTax(SouthCarolinaUnemployment::class)));
    }

    public function testSouthCarolinaUnemployment_notMetWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.south_carolina'));
            $taxes->setWorkLocation($this->getLocation('us.south_carolina'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(13700);
        });

        // 13700 + 200 = 13900
        // 14000 wage base not met, all taxable
        // round(200.0 * .0087, 2) = 1.74;
        $this->assertThat(1.74, self::identicalTo($results->getTax(SouthCarolinaUnemployment::class)));
    }

    public function testSouthCarolinaUnemployment_metAndExceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.south_carolina'));
            $taxes->setWorkLocation($this->getLocation('us.south_carolina'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(13900);
        });

        // 13900 + 200 = 14100
        // 100 over 14000 wage base so only 100 taxable
        // round(100.0 * .0087, 2) = 0.87;
        $this->assertThat(0.87, self::identicalTo($results->getTax(SouthCarolinaUnemployment::class)));
    }

    public function testSouthCarolinaUnemployment_exceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.south_carolina'));
            $taxes->setWorkLocation($this->getLocation('us.south_carolina'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(14000);
        });

        // 14200 exceeds 14000 wage base, none taxable
        $this->assertThat(null, self::identicalTo($results->getTax(SouthCarolinaUnemployment::class)));
    }
}
