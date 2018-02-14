<?php

namespace Appleton\Taxes\Countries\US\FederalIncome;

use Appleton\Taxes\Classes\Taxes;
use Appleton\Taxes\Models\TaxInformation;
use Appleton\Taxes\Models\Countries\US\FederalIncomeTaxInformation;

class FederalIncomeTest extends \TestCase
{
    public function testCalledTwice()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(0.0, $results->getTax(FederalIncome::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(0.0, $results->getTax(FederalIncome::class));
    }

    public function testNoTaxesOwed()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(0.0, $results->getTax(FederalIncome::class));

        FederalIncomeTaxInformation::forUser($this->user)->update(['filing_status' => FederalIncome::FILING_MARRIED]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(8650);
        });

        $this->assertSame(0.0, $results->getTax(FederalIncome::class));
    }

    public function testTaxesOwed()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2301);
        });

        $this->assertSame(0.10, $results->getTax(FederalIncome::class));

        FederalIncomeTaxInformation::forUser($this->user)->update(['filing_status' => FederalIncome::FILING_MARRIED]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(8651);
        });

        $this->assertSame(0.10, $results->getTax(FederalIncome::class));
    }

    public function testAdditionalWithholding()
    {
        FederalIncomeTaxInformation::forUser($this->user)->update(['additional_withholding' => 10]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(0);
        });

        $this->assertSame(0.0, $results->getTax(FederalIncome::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(1);
        });

        $this->assertSame(1.0, $results->getTax(FederalIncome::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(10);
        });

        $this->assertSame(10.0, $results->getTax(FederalIncome::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2301);
        });

        $this->assertSame(10.10, $results->getTax(FederalIncome::class));

        FederalIncomeTaxInformation::forUser($this->user)->update([
            'additional_withholding' => 20,
            'filing_status' => FederalIncome::FILING_MARRIED
        ]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(8651);
        });

        $this->assertSame(20.10, $results->getTax(FederalIncome::class));
    }

    public function testSupplemental()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setSupplementalEarnings(100);
        });

        $this->assertSame(25.00, $results->getTax(FederalIncome::class));
    }

    public function testWeekly()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(496.65, $results->getTax(FederalIncome::class));
    }

    public function testBimonthly()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
            $taxes->setPayPeriods(24);
        });

        $this->assertSame(373.49, $results->getTax(FederalIncome::class));
    }

    public function testMonthly()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
            $taxes->setPayPeriods(12);
        });

        $this->assertSame(277.40, $results->getTax(FederalIncome::class));
    }

    public function testNonNegative()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(10);
            $taxes->setPayPeriods(260);
        });

        $this->assertSame(0.12, $results->getTax(FederalIncome::class));
    }

    public function testCaseStudy1()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(66.68);
            $taxes->setPayPeriods(260);
        });

        $this->assertSame(6.88, $results->getTax(FederalIncome::class));
    }

    // 2018

    public function testTaxesOwed2018A()
    {
        FederalIncomeTaxInformation::forUser($this->user)->update(['exemptions' => 1]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(258.69);
            $taxes->setPayPeriods(52);
            $taxes->setDate($this->date('2018-01-01'));
        });

        $this->assertSame(10.77, $results->getTax(FederalIncome::class));
    }

    public function testTaxesOwed2018B()
    {
        FederalIncomeTaxInformation::forUser($this->user)->update([
            'exemptions' => 4,
            'filing_status' => FederalIncome::FILING_MARRIED,
        ]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(475.25);
            $taxes->setPayPeriods(52);
            $taxes->setDate($this->date('2018-01-01'));
        });

        $this->assertSame(0.0, $results->getTax(FederalIncome::class));
    }

    public function testTaxesOwed2018C()
    {
        FederalIncomeTaxInformation::forUser($this->user)->update([
            'exemptions' => 2,
        ]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(112.33);
            $taxes->setPayPeriods(52);
            $taxes->setDate($this->date('2018-01-01'));
        });

        $this->assertSame(0.0, $results->getTax(FederalIncome::class));
    }

    public function testTaxesOwed2018D()
    {
        FederalIncomeTaxInformation::forUser($this->user)->update(['filing_status' => FederalIncome::FILING_SEPERATE]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(865.14);
            $taxes->setPayPeriods(52);
            $taxes->setDate($this->date('2018-01-01'));
        });

        $this->assertSame(96.59, $results->getTax(FederalIncome::class));
    }

    public function testTaxesOwed2018E()
    {
        FederalIncomeTaxInformation::forUser($this->user)->update([
            'exemptions' => 3,
            'filing_status' => FederalIncome::FILING_MARRIED,
        ]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(367.57);
            $taxes->setPayPeriods(52);
            $taxes->setDate($this->date('2018-01-01'));
        });

        $this->assertSame(0.0, $results->getTax(FederalIncome::class));
    }

    public function testTaxesOwed2018H()
    {
        FederalIncomeTaxInformation::forUser($this->user)->update([
            'exemptions' => 2,
        ]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(800);
            $taxes->setPayPeriods(52);
            $taxes->setDate($this->date('2018-01-01'));
        });

        $this->assertSame(64.64, $results->getTax(FederalIncome::class));
    }
}
