<?php

namespace Appleton\Taxes\Countries\US\Kentucky\KentuckyIncome;

use Appleton\Taxes\Models\Countries\US\Kentucky\KentuckyIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class KentuckyIncomeTest extends TestCase
{
    private const PAY_PERIODS = 52;
    private const EARNINGS = 166.68;
    private const TAX_AMOUNT = 5.84;
    private const STANDARD_DEDUCTION = 2590;

    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    public function testKentuckyIncome(): void
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(self::EARNINGS);
            $taxes->setPayPeriods(self::PAY_PERIODS);
        });

        $this->assertThat(self::TAX_AMOUNT, self::identicalTo($results->getTax(KentuckyIncome::class)));
    }

    public function testKentuckyIncome_exemptions_do_not_effect_taxes(): void
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky'));
            $taxes->setUser($this->user);
            $taxes->setExemptions(5);
            $taxes->setEarnings(self::EARNINGS);
            $taxes->setPayPeriods(self::PAY_PERIODS);
        });

        $this->assertThat(self::TAX_AMOUNT, self::identicalTo($results->getTax(KentuckyIncome::class)));
    }

    public function testKentuckyIncome_have_not_met_standard_deduction(): void
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky'));
            $taxes->setUser($this->user);
            $taxes->setEarnings((self::STANDARD_DEDUCTION - self::EARNINGS) / self::PAY_PERIODS);
            $taxes->setPayPeriods(self::PAY_PERIODS);
        });

        $this->assertThat(null, self::identicalTo($results->getTax(KentuckyIncome::class)));
    }

    public function testKentuckyIncome_meet_standard_deduction(): void
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(self::STANDARD_DEDUCTION / self::PAY_PERIODS);
            $taxes->setPayPeriods(self::PAY_PERIODS);
        });

        $this->assertThat(null, self::identicalTo($results->getTax(KentuckyIncome::class)));
    }

    public function testKentuckyIncome_exceed_standard_deduction(): void
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky'));
            $taxes->setUser($this->user);
            $taxes->setEarnings((self::STANDARD_DEDUCTION + self::EARNINGS) / self::PAY_PERIODS);
            $taxes->setPayPeriods(self::PAY_PERIODS);
        });

        $this->assertThat(0.15, self::identicalTo($results->getTax(KentuckyIncome::class)));
    }

    public function testKentuckyIncome_exempt(): void
    {
        KentuckyIncomeTaxInformation::forUser($this->user)->update([
            'exempt' => true
        ]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(self::EARNINGS);
            $taxes->setPayPeriods(self::PAY_PERIODS);
        });

        $this->assertThat(null, self::identicalTo($results->getTax(KentuckyIncome::class)));
    }

    public function testKentuckyIncome_workOutOfState()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky'));
            $taxes->setWorkLocation($this->getLocation('us.alabama'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(self::EARNINGS);
            $taxes->setPayPeriods(self::PAY_PERIODS);
        });

        $this->assertNull($results->getTax(KentuckyIncome::class));
    }

    public function testKentuckyIncome_liveOutOfState()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alabama'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(self::EARNINGS);
            $taxes->setPayPeriods(self::PAY_PERIODS);
        });

        $this->assertThat(self::TAX_AMOUNT, self::identicalTo($results->getTax(KentuckyIncome::class)));
    }
}
