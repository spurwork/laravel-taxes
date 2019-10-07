<?php

namespace Appleton\Taxes\Unit\Countries\US\Washington;

use Appleton\Taxes\Classes\Taxes;
use Appleton\Taxes\Countries\US\Washington\WashingtonFamilyMedicalLeaveEmployer\WashingtonFamilyMedicalLeaveEmployer;
use Carbon\Carbon;
use TestCase;

class WashingtonFamilyMedicalLeaveEmployerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    public function testWashingtonFamilyMedicalLeaveEmployer(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.washington'));
            $taxes->setWorkLocation($this->getLocation('us.washington'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setTipAmount(100);
        });

        // round(200.0 - 100.0 * .004 * .3667, 2) = 0.15;
        $this->assertThat(0.15, self::identicalTo($results->getTax(WashingtonFamilyMedicalLeaveEmployer::class)));
    }

    public function testWashingtonFamilyMedicalLeaveEmployer_notMetWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.washington'));
            $taxes->setWorkLocation($this->getLocation('us.washington'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(132600);
            $taxes->setTipAmount(100);
        });

        // 132600 + 200 = 132800
        // 132900 wage base not met, all taxable
        // round(200.0 - 100.0 * .004 * .3667, 2) = 0.15;
        $this->assertThat(0.15, self::identicalTo($results->getTax(WashingtonFamilyMedicalLeaveEmployer::class)));
    }

    public function testWashingtonFamilyMedicalLeaveEmployer_metAndExceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.washington'));
            $taxes->setWorkLocation($this->getLocation('us.washington'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(132800);
            $taxes->setTipAmount(25);
        });

        // 132800 + 200 = 133000
        // 100 over 132900 wage base so only 100 taxable
        // round(100.0 -25 * .004 * .3667, 2) = 0.11;
        $this->assertThat(0.11, self::identicalTo($results->getTax(WashingtonFamilyMedicalLeaveEmployer::class)));
    }

    public function testWashingtonFamilyMedicalLeave_metAndExceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.washington'));
            $taxes->setWorkLocation($this->getLocation('us.washington'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(132800);
            $taxes->setTipAmount(125);
        });

        // 132800 + 200 = 133000
        // 100 over 132900 wage base so only 100 taxable
        // round(100.0 - 125 * .004 * .3667, 2) = is negative;
        $this->assertThat(null, self::identicalTo($results->getTax(WashingtonFamilyMedicalLeaveEmployer::class)));
    }

    public function testWashingtonFamilyMedicalLeaveEmployer_exceedWageBase(): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.washington'));
            $taxes->setWorkLocation($this->getLocation('us.washington'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(200.0);
            $taxes->setYtdEarnings(132900);
            $taxes->setTipAmount(100);
        });

        // 133100 exceeds 132900 wage base, none taxable
        $this->assertThat(null, self::identicalTo($results->getTax(WashingtonFamilyMedicalLeaveEmployer::class)));
    }
}
