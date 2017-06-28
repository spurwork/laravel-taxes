<?php

namespace Appleton\Taxes\Countries\US;

use Appleton\Taxes\Countries\US;

class FederalIncomeTest extends \TestCase
{
    public function testCompute()
    {
        $taxes = $this->app->make(FederalIncome::class);

        $result = $taxes
            ->withEarnings(2300)
            ->withExemptions(0)
            ->withFilingStatus(FederalIncome::FILING_SINGLE)
            ->withNonResidentAlien(false)
            ->withPayPeriods(1)
            ->compute();

        $this->assertSame(0.0, $result);
    }

    public function testNoTaxesOwed()
    {
        $taxes = $this->app->make(FederalIncome::class);

        $result = $taxes
            ->withEarnings(2300)
            ->withExemptions(0)
            ->withFilingStatus(FederalIncome::FILING_SINGLE)
            ->withNonResidentAlien(false)
            ->withPayPeriods(1)
            ->compute();

        $this->assertSame(0.0, $result);

        $result = $taxes
            ->withEarnings(8650)
            ->withExemptions(0)
            ->withFilingStatus(FederalIncome::FILING_MARRIED)
            ->withNonResidentAlien(false)
            ->withPayPeriods(1)
            ->compute();

        $this->assertSame(0.0, $result);
    }

    public function testTaxesOwed()
    {
        $taxes = $this->app->make(FederalIncome::class);

        $result = $taxes
            ->withEarnings(2301)
            ->withExemptions(0)
            ->withFilingStatus(FederalIncome::FILING_SINGLE)
            ->withNonResidentAlien(false)
            ->withPayPeriods(1)
            ->compute();

        $this->assertSame(0.10, $result);

        $result = $taxes
            ->withEarnings(8651)
            ->withExemptions(0)
            ->withFilingStatus(FederalIncome::FILING_MARRIED)
            ->withNonResidentAlien(false)
            ->withPayPeriods(1)
            ->compute();

        $this->assertSame(0.10, $result);
    }

    public function testWeekly()
    {
        $taxes = $this->app->make(FederalIncome::class);

        $result = $taxes
            ->withEarnings(2300)
            ->withExemptions(0)
            ->withFilingStatus(FederalIncome::FILING_SINGLE)
            ->withNonResidentAlien(false)
            ->withPayPeriods(52)
            ->compute();

        $this->assertSame(496.65, $result);
    }

    public function testBimonthly()
    {
        $taxes = $this->app->make(FederalIncome::class);

        $result = $taxes
            ->withEarnings(2300)
            ->withExemptions(0)
            ->withFilingStatus(FederalIncome::FILING_SINGLE)
            ->withNonResidentAlien(false)
            ->withPayPeriods(24)
            ->compute();

        $this->assertSame(373.49, $result);
    }

    public function testMonthly()
    {
        $taxes = $this->app->make(FederalIncome::class);

        $result = $taxes
            ->withEarnings(2300)
            ->withExemptions(0)
            ->withFilingStatus(FederalIncome::FILING_SINGLE)
            ->withNonResidentAlien(false)
            ->withPayPeriods(12)
            ->compute();

        $this->assertSame(277.40, $result);
    }

    public function testCaseStudy1()
    {
        $taxes = $this->app->make(FederalIncome::class);

        $result = $taxes
            ->withEarnings(66.68)
            ->withExemptions(0)
            ->withFilingStatus(FederalIncome::FILING_SINGLE)
            ->withNonResidentAlien(false)
            ->withPayPeriods(260)
            ->compute();

        $this->assertSame(6.88, $result);
    }

    public function testNonNegative()
    {
        $taxes = $this->app->make(FederalIncome::class);

        $result = $taxes
            ->withEarnings(10)
            ->withExemptions(1)
            ->withFilingStatus(FederalIncome::FILING_SINGLE)
            ->withNonResidentAlien(false)
            ->withPayPeriods(260)
            ->compute();

        $this->assertSame(0.0, $result);
    }

    public function testSupplementalWages()
    {
        $taxes = $this->app->make(FederalIncome::class);

        $result = $taxes
            ->withEarnings(0)
            ->withSupplementalWages(100)
            ->withExemptions(1)
            ->withFilingStatus(FederalIncome::FILING_SINGLE)
            ->withNonResidentAlien(false)
            ->withPayPeriods(260)
            ->compute();

        $this->assertSame(25.0, $result);
    }
}
