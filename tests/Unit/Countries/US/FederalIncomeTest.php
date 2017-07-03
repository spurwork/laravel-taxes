<?php

namespace Appleton\Taxes\Countries\US\FederalIncome;

use Appleton\Taxes\Classes\Taxes;
use Appleton\Taxes\Models\TaxInformation;
use Appleton\Taxes\Models\Countries\US\FederalIncomeTaxInformation;

class FederalIncomeTest extends \TestCase
{
    public function testFederalIncome()
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

        FederalIncomeTaxInformation::forUser($this->user)->update(['filing_status' => Taxes::resolve(FederalIncome::class)::FILING_MARRIED]);

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

        FederalIncomeTaxInformation::forUser($this->user)->update(['filing_status' => Taxes::resolve(FederalIncome::class)::FILING_MARRIED]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(8651);
        });

        $this->assertSame(0.10, $results->getTax(FederalIncome::class));
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
}
