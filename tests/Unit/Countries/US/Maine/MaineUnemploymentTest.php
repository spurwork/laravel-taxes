<?php

namespace Appleton\Taxes\Unit\Countries\US\Maine;

use Appleton\Taxes\Classes\Taxes;
use Appleton\Taxes\Countries\US\Maine\MaineUnemployment\MaineUnemployment;
use Carbon\Carbon;
use TestCase;

class MaineUnemploymentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    public function testMaineUnemployment(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.maine'));
            $taxes->setWorkLocation($this->getLocation('us.maine'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
        });

        // round(200.0 * .0189, 2) = 3.78;
        $this->assertThat(3.78, self::identicalTo($results->getTax(MaineUnemployment::class)));
    }

    public function testMaineUnemployment_notMetWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.maine'));
            $taxes->setWorkLocation($this->getLocation('us.maine'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(11700);
        });

        // 11700 + 200 = 11900
        // 12000 wage base not met, all taxable
        // round(200.0 * .0189, 2) = 3.78;
        $this->assertThat(3.78, self::identicalTo($results->getTax(MaineUnemployment::class)));
    }

    public function testMaineUnemployment_metAndExceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.maine'));
            $taxes->setWorkLocation($this->getLocation('us.maine'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(11900);
        });

        // 11900 + 200 = 12100
        // 100 over 12000 wage base so only 100 taxable
        // round(100.0 * .0189, 2) = 1.89;
        $this->assertThat(1.89, self::identicalTo($results->getTax(MaineUnemployment::class)));
    }

    public function testMaineUnemployment_exceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.maine'));
            $taxes->setWorkLocation($this->getLocation('us.maine'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(12000);
        });

        // 12200 exceeds 12000 wage base, none taxable
        $this->assertThat(null, self::identicalTo($results->getTax(MaineUnemployment::class)));
    }
}
