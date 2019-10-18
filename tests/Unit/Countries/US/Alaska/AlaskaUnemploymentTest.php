<?php

namespace Appleton\Taxes\Unit\Countries\US\Alaska;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes;
use Appleton\Taxes\Countries\US\Alaska\AlaskaUnemployment\AlaskaUnemployment;
use Carbon\Carbon;
use TestCase;

class AlaskaUnemploymentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    public function testAlaskaUnemployment(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alaska'));
            $taxes->setWorkLocation($this->getLocation('us.alaska'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
        });

        // round(200.0 * .0132, 2) = 2.64;
        $this->assertThat(2.64, self::identicalTo($results->getTax(AlaskaUnemployment::class)));
    }

    public function testAlaskaUnemploymentNotMetWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alaska'));
            $taxes->setWorkLocation($this->getLocation('us.alaska'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(39600);
        });

        // 39600 + 200 = 39800
        // 39900 wage base not met, all taxable
        // round(200.0 * .0132, 2) = 2.64;
        $this->assertThat(2.64, self::identicalTo($results->getTax(AlaskaUnemployment::class)));
    }

    public function testAlaskaUnemploymentMetAndExceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alaska'));
            $taxes->setWorkLocation($this->getLocation('us.alaska'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(39800);
        });

        // 39800 + 200 = 40000
        // 100 over 39900 wage base so only 100 taxable
        // round(100.0 * .0132, 2) = 1.32;
        $this->assertThat(1.32, self::identicalTo($results->getTax(AlaskaUnemployment::class)));
    }

    public function testAlaskaUnemploymentExceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alaska'));
            $taxes->setWorkLocation($this->getLocation('us.alaska'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(39900);
        });

        // 40100 exceeds 39900 wage base, none taxable
        $this->assertThat(null, self::identicalTo($results->getTax(AlaskaUnemployment::class)));
    }
}
