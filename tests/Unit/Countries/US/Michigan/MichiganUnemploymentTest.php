<?php

namespace Appleton\Taxes\Unit\Countries\US\Michigan;

use Appleton\Taxes\Classes\Taxes;
use Appleton\Taxes\Countries\US\Michigan\MichiganUnemployment\MichiganUnemployment;
use Carbon\Carbon;
use TestCase;

class MichiganUnemploymentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    public function testMichiganUnemployment(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.michigan'));
            $taxes->setWorkLocation($this->getLocation('us.michigan'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
        });

        // round(200.0 * .027, 2) = 5.40;
        $this->assertThat(5.40, self::identicalTo($results->getTax(MichiganUnemployment::class)));
    }

    public function testMichiganUnemployment_notMetWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.michigan'));
            $taxes->setWorkLocation($this->getLocation('us.michigan'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(190.0);
            $taxes->setYtdEarnings(7800);
        });

        // 7800 + 190 = 7990
        // 9000 wage base not met, all taxable
        // round(190.0 * .027, 2) = 5.13;
        $this->assertThat(5.13, self::identicalTo($results->getTax(MichiganUnemployment::class)));
    }

    public function testMichiganUnemployment_metAndExceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.michigan'));
            $taxes->setWorkLocation($this->getLocation('us.michigan'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(210.0);
            $taxes->setYtdEarnings(8800);
        });

        // 8800 + 210 = 9010
        // 10 over 9000 wage base so only 200 taxable
        // round(200.0 * .027, 2) = 5.40;
        $this->assertThat(5.40, self::identicalTo($results->getTax(MichiganUnemployment::class)));
    }

    public function testMichiganUnemployment_exceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.michigan'));
            $taxes->setWorkLocation($this->getLocation('us.michigan'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(9100);
        });

        // 9100 exceeds 9000 wage base, none taxable
        $this->assertThat(0.0, self::identicalTo($results->getTax(MichiganUnemployment::class)));
    }
}
