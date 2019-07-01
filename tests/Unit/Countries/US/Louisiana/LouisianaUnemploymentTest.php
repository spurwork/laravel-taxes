<?php
 namespace Appleton\Taxes\Unit\Countries\US\Louisiana;

use Appleton\Taxes\Classes\Taxes;
use Appleton\Taxes\Countries\US\Louisiana\LouisianaUnemployment\LouisianaUnemployment;
use Carbon\Carbon;
use TestCase;

class LouisianaUnemploymentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    public function testLouisianaUnemployment(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.louisiana'));
            $taxes->setWorkLocation($this->getLocation('us.louisiana'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
        });

        // round(200.0 * .03, 2) = 6.0;
        $this->assertThat(6.0, self::identicalTo($results->getTax(LouisianaUnemployment::class)));
    }

    public function testLouisianaUnemployment_notMetWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.louisiana'));
            $taxes->setWorkLocation($this->getLocation('us.louisiana'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(190.0);
            $taxes->setYtdEarnings(6800);
        });

        // 6800 + 190 = 6990
        // 7000 wage base not met, all taxable
        // round(190.0 * .03, 2) = 5.7;
        $this->assertThat(5.7, self::identicalTo($results->getTax(LouisianaUnemployment::class)));
    }

    public function testLouisianaUnemployment_metAndExceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.louisiana'));
            $taxes->setWorkLocation($this->getLocation('us.louisiana'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(210.0);
            $taxes->setYtdEarnings(6800);
        });

        // 6800 + 210 = 7010
        // 100 over 7000 wage base so only 200 taxable
        // round(200.0 * .03, 2) = 6.0;
        $this->assertThat(6.0, self::identicalTo($results->getTax(LouisianaUnemployment::class)));
    }

    public function testLouisianaUnemployment_exceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.louisiana'));
            $taxes->setWorkLocation($this->getLocation('us.louisiana'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(7100);
        });

        // 7100 exceeds 7000 wage base, none taxable
        $this->assertThat(null, self::identicalTo($results->getTax(LouisianaUnemployment::class)));
    }
}
