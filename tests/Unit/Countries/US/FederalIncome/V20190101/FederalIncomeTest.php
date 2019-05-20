<?php

namespace Appleton\Taxes\Countries\US\FederalIncome\V20190101;

use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome as ParentFederalIncome;
use Appleton\Taxes\Models\Countries\US\FederalIncomeTaxInformation;

class FederalIncomeTest extends \TestCase
{
    public function testTaxesOwed2019A()
    {
        FederalIncomeTaxInformation::forUser($this->user)->update(['exemptions' => 1]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us'));
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(258.69);
            $taxes->setPayPeriods(52);
            $taxes->setDate($this->date('2019-01-01'));
        });

        $this->assertSame(10.48, $results->getTax(ParentFederalIncome::class));
    }

    public function testTaxesOwed2019B()
    {
        FederalIncomeTaxInformation::forUser($this->user)->update([
            'exemptions' => 4,
            'filing_status' => ParentFederalIncome::FILING_MARRIED,
        ]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us'));
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(475.25);
            $taxes->setPayPeriods(52);
            $taxes->setDate($this->date('2019-01-01'));
        });

        $this->assertSame(0.0, $results->getTax(ParentFederalIncome::class));
    }

    public function testTaxesOwed2019C()
    {
        FederalIncomeTaxInformation::forUser($this->user)->update([
            'exemptions' => 2,
        ]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us'));
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(112.33);
            $taxes->setPayPeriods(52);
            $taxes->setDate($this->date('2019-01-01'));
        });

        $this->assertSame(0.0, $results->getTax(ParentFederalIncome::class));
    }

    public function testTaxesOwed2019D()
    {
        FederalIncomeTaxInformation::forUser($this->user)->update(['filing_status' => ParentFederalIncome::FILING_SEPARATE]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us'));
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(865.14);
            $taxes->setPayPeriods(52);
            $taxes->setDate($this->date('2019-01-01'));
        });

        $this->assertSame(94.60, $results->getTax(ParentFederalIncome::class));
    }

    public function testTaxesOwed2019E()
    {
        FederalIncomeTaxInformation::forUser($this->user)->update([
            'exemptions' => 3,
            'filing_status' => ParentFederalIncome::FILING_MARRIED,
        ]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us'));
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(367.57);
            $taxes->setPayPeriods(52);
            $taxes->setDate($this->date('2019-01-01'));
        });

        $this->assertSame(0.0, $results->getTax(ParentFederalIncome::class));
    }

    public function testTaxesOwed2019H()
    {
        FederalIncomeTaxInformation::forUser($this->user)->update([
            'exemptions' => 2,
        ]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us'));
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(800);
            $taxes->setPayPeriods(52);
            $taxes->setDate($this->date('2019-01-01'));
        });

        $this->assertSame(64.11, $results->getTax(ParentFederalIncome::class));
    }

    public function testFederalIncomeUseDefault() {
        FederalIncomeTaxInformation::forUser($this->user)->delete();

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us'));
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(800);
            $taxes->setPayPeriods(52);
            $taxes->setDate($this->date('2019-01-01'));
        });

        $this->assertSame(83.50, $results->getTax(ParentFederalIncome::class));
    }
}
