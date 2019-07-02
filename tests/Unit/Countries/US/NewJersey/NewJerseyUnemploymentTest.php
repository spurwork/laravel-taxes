<?php

namespace Appleton\Taxes\Unit\Countries\US\NewJersey;

use Appleton\Taxes\Classes\Taxes;
use Appleton\Taxes\Countries\US\NewJersey\NewJerseyUnemployment\NewJerseyUnemployment;
use Carbon\Carbon;
use TestCase;

class NewJerseyUnemploymentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    public function testNewJerseyUnemployment(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.new_jersey'));
            $taxes->setWorkLocation($this->getLocation('us.new_jersey'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
        });

        // round(200.0 * .028, 2) = 5.60;
        $this->assertThat(5.60, self::identicalTo($results->getTax(NewJerseyUnemployment::class)));
    }

    public function testNewJerseyUnemployment_notMetWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.new_jersey'));
            $taxes->setWorkLocation($this->getLocation('us.new_jersey'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(190.0);
            $taxes->setYtdEarnings(7800);
        });

        // 7800 + 190 = 7990
        // 9000 wage base not met, all taxable
        // round(190.0 * .028, 2) = 5.32;
        $this->assertThat(5.32, self::identicalTo($results->getTax(NewJerseyUnemployment::class)));
    }

    public function testNewJerseyUnemployment_metAndExceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.new_jersey'));
            $taxes->setWorkLocation($this->getLocation('us.new_jersey'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(210.0);
            $taxes->setYtdEarnings(34200);
        });

        // 34200 + 210 = 34410
        // 100 over 34400 wage base so only 200 taxable
        // round(200.0 * .028, 2) = 5.60;
        $this->assertThat(5.60, self::identicalTo($results->getTax(NewJerseyUnemployment::class)));
    }

    public function testNewJerseyUnemployment_exceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.new_jersey'));
            $taxes->setWorkLocation($this->getLocation('us.new_jersey'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(34500);
        });

        // 34500 exceeds 34400 wage base, none taxable
        $this->assertThat(null, self::identicalTo($results->getTax(NewJerseyUnemployment::class)));
    }
}
