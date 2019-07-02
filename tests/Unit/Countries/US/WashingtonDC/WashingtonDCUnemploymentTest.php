<?php

namespace Appleton\Taxes\Unit\Countries\US\WashingtonDC;

use Appleton\Taxes\Classes\Taxes;
use Appleton\Taxes\Countries\US\WashingtonDC\WashingtonDCUnemployment\WashingtonDCUnemployment;
use Carbon\Carbon;
use TestCase;

class WashingtonDCUnemploymentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    public function testWashingtonDCUnemployment(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.washingtondc'));
            $taxes->setWorkLocation($this->getLocation('us.washingtondc'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
        });

        // round(200.0 * .027, 2) = 5.40;
        $this->assertThat(5.40, self::identicalTo($results->getTax(WashingtonDCUnemployment::class)));
    }

    public function testWashingtonDCUnemployment_notMetWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.washingtondc'));
            $taxes->setWorkLocation($this->getLocation('us.washingtondc'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(190.0);
            $taxes->setYtdEarnings(8800);
        });

        // 8800 + 190 = 8990
        // 9000 wage base not met, all taxable
        // round(190.0 * .027, 2) = 5.13;
        $this->assertThat(5.13, self::identicalTo($results->getTax(WashingtonDCUnemployment::class)));
    }

    public function testWashingtonDCUnemployment_metAndExceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.washingtondc'));
            $taxes->setWorkLocation($this->getLocation('us.washingtondc'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(210.0);
            $taxes->setYtdEarnings(8800);
        });

        // 8800 + 210 = 9010
        // 10 over 9000 wage base so only 200 taxable
        // round(200.0 * .027, 2) = 5.40;
        $this->assertThat(5.40, self::identicalTo($results->getTax(WashingtonDCUnemployment::class)));
    }

    public function testWashingtonDCUnemployment_exceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.washingtondc'));
            $taxes->setWorkLocation($this->getLocation('us.washingtondc'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(9100);
        });

        // 9100 exceeds 9000 wage base, none taxable
        $this->assertThat(null, self::identicalTo($results->getTax(WashingtonDCUnemployment::class)));
    }
}
