<?php

namespace Appleton\Taxes\Unit\Countries\US\Oklahoma;

use Appleton\Taxes\Classes\Taxes;
use Appleton\Taxes\Countries\US\Oklahoma\OklahomaUnemployment\OklahomaUnemployment;
use Carbon\Carbon;
use TestCase;

class OklahomaUnemploymentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    public function testOklahomaUnemployment(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.oklahoma'));
            $taxes->setWorkLocation($this->getLocation('us.oklahoma'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
        });

        // round(200.0 * .015, 2) = 5.60;
        $this->assertThat(3, self::identicalTo($results->getTax(OklahomaUnemployment::class)));
    }

    public function testOklahomaUnemployment_notMetWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.oklahoma'));
            $taxes->setWorkLocation($this->getLocation('us.oklahoma'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(17900);
        });

        // 17900 + 200 = 18050
        // 18100 wage base not met, all taxable
        // round(200.0 * .015, 2) = 3;
        $this->assertThat(3, self::identicalTo($results->getTax(OklahomaUnemployment::class)));
    }

    public function testOklahomaUnemployment_metAndExceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.oklahoma'));
            $taxes->setWorkLocation($this->getLocation('us.oklahoma'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(18000);
        });

        // 18000 + 200 = 18200
        // 100 over 18100 wage base so only 200 taxable
        // round(100.0 * .015, 2) = 1.5;
        $this->assertThat(1, self::identicalTo($results->getTax(OklahomaUnemployment::class)));
    }

    public function testOklahomaUnemployment_exceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.oklahoma'));
            $taxes->setWorkLocation($this->getLocation('us.oklahoma'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(18200);
        });

        // 18500 exceeds 18100 wage base, none taxable
        $this->assertThat(0, self::identicalTo($results->getTax(OklahomaUnemployment::class)));
    }
}
