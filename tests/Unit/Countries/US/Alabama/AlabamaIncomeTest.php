<?php

namespace Appleton\Taxes\Countries\US\Alabama\AlabamaIncome;

use Appleton\Taxes\Models\Tax;
use Appleton\Taxes\Models\Countries\US\Alabama\AlabamaIncomeTaxInformation;
use Carbon\Carbon;

class AlabamaIncomeTest extends \TestCase
{
    public function testAlabamaIncome()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alabama'));
            $taxes->setWorkLocation($this->getLocation('us.alabama'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(66.68);
            $taxes->setPayPeriods(260);
        });

        $this->assertSame(2.06, $results->getTax(AlabamaIncome::class));

        Carbon::setTestNow(
            Carbon::parse('January 1, 2018 8am', 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alabama'));
            $taxes->setWorkLocation($this->getLocation('us.alabama'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(66.68);
            $taxes->setPayPeriods(260);
        });

        $this->assertSame(2.13, $results->getTax(AlabamaIncome::class));
    }

    public function testAlabamaAdditionalWithholding()
    {
        AlabamaIncomeTaxInformation::forUser($this->user)->update(['additional_withholding' => 10]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alabama'));
            $taxes->setWorkLocation($this->getLocation('us.alabama'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(0);
            $taxes->setPayPeriods(260);
        });

        $this->assertSame(0.0, $results->getTax(AlabamaIncome::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alabama'));
            $taxes->setWorkLocation($this->getLocation('us.alabama'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(1);
            $taxes->setPayPeriods(260);
        });

        $this->assertSame(0.92, $results->getTax(AlabamaIncome::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alabama'));
            $taxes->setWorkLocation($this->getLocation('us.alabama'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(10);
            $taxes->setPayPeriods(260);
        });

        $this->assertSame(9.11, $results->getTax(AlabamaIncome::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alabama'));
            $taxes->setWorkLocation($this->getLocation('us.alabama'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(66.68);
            $taxes->setPayPeriods(260);
        });

        $this->assertSame(12.06, $results->getTax(AlabamaIncome::class));
    }

    public function testAlabamaSupplemental()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alabama'));
            $taxes->setWorkLocation($this->getLocation('us.alabama'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setSupplementalEarnings(100);
        });

        $this->assertSame(5.00, $results->getTax(AlabamaIncome::class));
    }

    public function testAlabamaIncomeNonNegative()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alabama'));
            $taxes->setWorkLocation($this->getLocation('us.alabama'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(10);
            $taxes->setPayPeriods(260);
        });

        $this->assertSame(0.0, $results->getTax(AlabamaIncome::class));
    }

    public function testAlabamaIncomeWithNoPersonalExemption()
    {
        AlabamaIncomeTaxInformation::forUser($this->user)->update(['filing_status' => AlabamaIncome::FILING_ZERO]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alabama'));
            $taxes->setWorkLocation($this->getLocation('us.alabama'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(66.68);
            $taxes->setPayPeriods(260);
        });

        $this->assertSame(2.83, $results->getTax(AlabamaIncome::class));
    }

    public function testAlabamaIncomeUseDefault()
    {
        AlabamaIncomeTaxInformation::forUser($this->user)->delete();

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alabama'));
            $taxes->setWorkLocation($this->getLocation('us.alabama'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(66.68);
            $taxes->setPayPeriods(260);
        });

        $this->assertSame(2.06, $results->getTax(AlabamaIncome::class));
    }

    public function testAlabamaIncomeWorkInTennessee()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alabama'));
            $taxes->setWorkLocation($this->getLocation('us.tennessee'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(66.68);
            $taxes->setPayPeriods(260);
        });

        $this->assertSame(2.06, $results->getTax(AlabamaIncome::class));
    }

    public function testAlabamaIncomeClaimExempt()
    {
        $alabama_income_tax_information = AlabamaIncomeTaxInformation::forUser($this->user);
        $alabama_income_tax_information->update([
            'exempt' => true
        ]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alabama'));
            $taxes->setWorkLocation($this->getLocation('us.alabama'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(66.68);
            $taxes->setPayPeriods(260);
        });

        $this->assertSame(0.00, $results->getTax(AlabamaIncome::class));

        $alabama_income_tax_information->update([
            'exempt' => false
        ]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alabama'));
            $taxes->setWorkLocation($this->getLocation('us.alabama'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(66.68);
            $taxes->setPayPeriods(260);
        });
        $this->assertSame(2.06,  $results->getTax(AlabamaIncome::class));
    }
}
