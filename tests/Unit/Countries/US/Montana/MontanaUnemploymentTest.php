<?php

namespace Appleton\Taxes\Unit\Countries\US\Montana;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes;
use Appleton\Taxes\Countries\US\Montana\MontanaUnemployment\MontanaUnemployment;
use Carbon\Carbon;
use TestCase;

class MontanaUnemploymentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    public function testMontanaUnemployment(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.montana'));
            $taxes->setWorkLocation($this->getLocation('us.montana'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
        });

        // round(200.0 * .0258, 2) = 5.16;
        $this->assertThat(5.16, self::identicalTo($results->getTax(MontanaUnemployment::class)));
    }

    public function testMontanaUnemployment_notMetWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.montana'));
            $taxes->setWorkLocation($this->getLocation('us.montana'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(32000);
        });

        // 32000 + 200 = 32200
        // 33000 wage base not met, all taxable
        // round(200.0 * .0258, 2) = 5.16;
        $this->assertThat(5.16, self::identicalTo($results->getTax(MontanaUnemployment::class)));
    }

    public function testMontanaUnemployment_metAndExceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.montana'));
            $taxes->setWorkLocation($this->getLocation('us.montana'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(32900);
        });

        // 32900 + 200 = 32100
        // 100 over 33000 wage base so only 100 taxable
        // round(100.0 * .0258, 2) = 2.58;
        $this->assertThat(2.58, self::identicalTo($results->getTax(MontanaUnemployment::class)));
    }

    public function testMontanaUnemployment_exceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.montana'));
            $taxes->setWorkLocation($this->getLocation('us.montana'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(33000);
        });

        // 33200 exceeds 33000 wage base, none taxable
        $this->assertThat(null, self::identicalTo($results->getTax(MontanaUnemployment::class)));
    }
}
