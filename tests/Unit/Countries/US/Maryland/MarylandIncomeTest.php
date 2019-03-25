<?php

namespace Appleton\Taxes\Unit\Countries\US\Maryland;

use Appleton\Taxes\Countries\US\Maryland\MarylandIncome\MarylandIncome;
use Appleton\Taxes\Models\Countries\US\Maryland\MarylandIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class MarylandIncomeTest extends TestCase
{
    private const PAY_PERIODS = 52;

    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    public function testMarylandIncomeDefault()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.maryland'));
            $taxes->setWorkLocation($this->getLocation('us.maryland'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100.00);
            $taxes->setPayPeriods(self::PAY_PERIODS);
        });

        $this->assertThat(3.37, self::identicalTo($results->getTax(MarylandIncome::class)));
    }

    public function testMarylandIncomeSingleOverOneHundredThousand()
    {
        MarylandIncomeTaxInformation::forUser($this->user)->update([
            'additional_withholding' => 0,
            'dependents' => 0,
            'personal_allowances' => 0,
            'allowances' => 0,
            'filing_status' => MarylandIncome::FILING_SINGLE,
            'exempt' => false,
        ]);
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.maryland'));
            $taxes->setWorkLocation($this->getLocation('us.maryland'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2000.00);
            $taxes->setPayPeriods(self::PAY_PERIODS);
            $taxes->setYtdEarnings(100001.00);
        });

        $this->assertThat(93.69, self::identicalTo($results->getTax(MarylandIncome::class)));
    }

    public function testMarylandIncomeSingleOverOneHundredThousandWithDependants()
    {
        MarylandIncomeTaxInformation::forUser($this->user)->update([
            'additional_withholding' => 0,
            'dependents' => 1,
            'personal_allowances' => 0,
            'allowances' => 0,
            'filing_status' => MarylandIncome::FILING_SINGLE,
            'exempt' => false,
        ]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.maryland'));
            $taxes->setWorkLocation($this->getLocation('us.maryland'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2000.00);
            $taxes->setPayPeriods(self::PAY_PERIODS);
            $taxes->setYtdEarnings(100001.00);
        });

        $this->assertThat(90.65, self::identicalTo($results->getTax(MarylandIncome::class)));
    }

    public function testMarylandIncomeWorkInDelaware()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.maryland'));
            $taxes->setWorkLocation($this->getLocation('us.delaware'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100.00);
            $taxes->setPayPeriods(self::PAY_PERIODS);
        });

        $this->assertThat(4.83, self::identicalTo($results->getTax(MarylandIncome::class)));
    }
}