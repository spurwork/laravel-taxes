<?php

namespace Appleton\Taxes\Unit\Countries\US\Virginia;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes;
use Appleton\Taxes\Countries\US\Virginia\VirginiaUnemployment\VirginiaUnemployment;
use Carbon\Carbon;
use TestCase;

class VirginiaUnemploymentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    public function testVirginiaUnemployment(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.virginia'));
            $taxes->setWorkLocation($this->getLocation('us.virginia'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
        });

        // round(200.0 * .0251, 2) = 5.02;
        $this->assertThat(5.02, self::identicalTo($results->getTax(VirginiaUnemployment::class)));
    }

    public function testVirginiaUnemployment_notMetWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.virginia'));
            $taxes->setWorkLocation($this->getLocation('us.virginia'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(190.0);
            $taxes->setYtdEarnings(7800);
        });

        // 7800 + 190 = 7990
        // 8000 wage base not met, all taxable
        // round(190.0 * .0251, 2) = 4.77;
        $this->assertThat(4.77, self::identicalTo($results->getTax(VirginiaUnemployment::class)));
    }

    public function testVirginiaUnemployment_metAndExceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.virginia'));
            $taxes->setWorkLocation($this->getLocation('us.virginia'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(210.0);
            $taxes->setYtdEarnings(7800);
        });

        // 7800 + 210 = 8010
        // 10 over 8000 wage base so only 200 taxable
        // round(200.0 * .0251, 2) = 5.02;
        $this->assertThat(5.02, self::identicalTo($results->getTax(VirginiaUnemployment::class)));
    }

    public function testVirginiaUnemployment_exceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.virginia'));
            $taxes->setWorkLocation($this->getLocation('us.virginia'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(8100);
        });

        // 8100 exceeds 8000 wage base, none taxable
        $this->assertThat(null, self::identicalTo($results->getTax(VirginiaUnemployment::class)));
    }
}
