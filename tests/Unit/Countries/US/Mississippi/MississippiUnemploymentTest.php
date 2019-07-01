<?php

namespace Appleton\Taxes\Unit\Countries\US\Mississippi;

use Appleton\Taxes\Classes\Taxes;
use Appleton\Taxes\Countries\US\Mississippi\MississippiUnemployment\MississippiUnemployment;
use Carbon\Carbon;
use TestCase;

class MississippiUnemploymentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    public function testMississippiUnemployment(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.mississippi'));
            $taxes->setWorkLocation($this->getLocation('us.mississippi'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
        });

        // round(200.0 * .012, 2) = 2.4;
        $this->assertThat(2, self::identicalTo($results->getTax(MississippiUnemployment::class)));
    }

    public function testMississippiUnemployment_notMetWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.mississippi'));
            $taxes->setWorkLocation($this->getLocation('us.mississippi'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(190.0);
            $taxes->setYtdEarnings(1200);
        });

        // 1200 + 190 = 1390
        // 9000 wage base not met, all taxable
        // round(190.0 * .012, 2) = 2.28;
        $this->assertThat(2, self::identicalTo($results->getTax(MississippiUnemployment::class)));
    }

    public function testMississippiUnemployment_metAndExceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.mississippi'));
            $taxes->setWorkLocation($this->getLocation('us.mississippi'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(210.0);
            $taxes->setYtdEarnings(1200);
        });

        // 1200 + 210 = 1410
        // 10 over 1400 wage base so only 200 taxable
        // round(200.0 * .012, 2) = 2.38;
        $this->assertThat(2, self::identicalTo($results->getTax(MississippiUnemployment::class)));
    }

    public function testMississippiUnemployment_exceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.mississippi'));
            $taxes->setWorkLocation($this->getLocation('us.mississippi'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(1410);
        });

        // 9100 exceeds 9000 wage base, none taxable
        $this->assertThat(null, self::identicalTo($results->getTax(MississippiUnemployment::class)));
    }
}
