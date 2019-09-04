<?php

namespace Appleton\Taxes\Unit\Countries\US\Nebraska;

use Appleton\Taxes\Classes\Taxes;
use Appleton\Taxes\Countries\US\Nebraska\NebraskaUnemployment\NebraskaUnemployment;
use Carbon\Carbon;
use TestCase;

class NebraskaUnemploymentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    public function testNebraskaUnemployment(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.nebraska'));
            $taxes->setWorkLocation($this->getLocation('us.nebraska'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
        });

        // round(200.0 * .0125, 2) = 2.5;
        $this->assertThat(2.5, self::identicalTo($results->getTax(NebraskaUnemployment::class)));
    }

    public function testNebraskaUnemployment_notMetWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.nebraska'));
            $taxes->setWorkLocation($this->getLocation('us.nebraska'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(8700);
        });

        // 8700 + 200 = 8900
        // 9000 wage base not met, all taxable
        // round(200.0 * .0125, 2) = 2.5;
        $this->assertThat(2.5, self::identicalTo($results->getTax(NebraskaUnemployment::class)));
    }

    public function testNebraskaUnemployment_metAndExceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.nebraska'));
            $taxes->setWorkLocation($this->getLocation('us.nebraska'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(8900);
        });

        // 8900 + 200 = 9100
        // 100 over 9000 wage base so only 100 taxable
        // round(100.0 * .0125, 2) = 1.25;
        $this->assertThat(1.25, self::identicalTo($results->getTax(NebraskaUnemployment::class)));
    }

    public function testNebraskaUnemployment_exceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.nebraska'));
            $taxes->setWorkLocation($this->getLocation('us.nebraska'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(9000);
        });

        // 9200 exceeds 9000 wage base, none taxable
        $this->assertThat(null, self::identicalTo($results->getTax(NebraskaUnemployment::class)));
    }
}
