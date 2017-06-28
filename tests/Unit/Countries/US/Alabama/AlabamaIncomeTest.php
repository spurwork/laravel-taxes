<?php

namespace Appleton\Taxes\Countries\US\Alabama;

use Appleton\Taxes\Countries\US\FederalIncome;
use Appleton\Taxes\Countries\US\Alabama\AlabamaIncome;

class AlabamaIncomeTest extends \TestCase
{
    public function testAlabamaIncome()
    {
        $taxes = $this->app->make(FederalIncome::class);

        $result = $taxes
            ->withEarnings(66.68)
            ->withExemptions(0)
            ->withFilingStatus(FederalIncome::FILING_SINGLE)
            ->withNonResidentAlien(false)
            ->withPayPeriods(260)
            ->compute();

        $taxes = $this->app->make(AlabamaIncome::class);

        $result = $taxes
            ->withEarnings(66.68)
            ->withFilingStatus(AlabamaIncome::FILING_SINGLE)
            ->withPayPeriods(260)
            ->withFederalIncomeTax($result)
            ->compute();

        $this->assertSame(2.07, $result);
    }

    public function testAlabamaIncomeNonNegative()
    {
        $taxes = $this->app->make(AlabamaIncome::class);

        $result = $taxes
            ->withEarnings(10)
            ->withFilingStatus(AlabamaIncome::FILING_SINGLE)
            ->withPayPeriods(260)
            ->withFederalIncomeTax(0)
            ->compute();

        $this->assertSame(0.0, $result);
    }

    public function testAlabamaIncomeWithNoPersonalExemption()
    {
        $taxes = $this->app->make(FederalIncome::class);

        $result = $taxes
            ->withEarnings(66.68)
            ->withExemptions(0)
            ->withFilingStatus(FederalIncome::FILING_SINGLE)
            ->withNonResidentAlien(false)
            ->withPayPeriods(260)
            ->compute();

        $taxes = $this->app->make(AlabamaIncome::class);

        $result = $taxes
            ->withEarnings(66.68)
            ->withFilingStatus(AlabamaIncome::FILING_SINGLE)
            ->withPersonalExemption(false)
            ->withPayPeriods(260)
            ->withFederalIncomeTax($result)
            ->compute();

        $this->assertSame(2.36, $result);
    }

    public function testAlabamaSupplementalWages()
    {
        $taxes = $this->app->make(FederalIncome::class);

        $result = $taxes
            ->withEarnings(66.68)
            ->withExemptions(0)
            ->withFilingStatus(FederalIncome::FILING_SINGLE)
            ->withNonResidentAlien(false)
            ->withPayPeriods(260)
            ->compute();

        $taxes = $this->app->make(AlabamaIncome::class);

        $result = $taxes
            ->withEarnings(66.68)
            ->withSupplementalWages(100)
            ->withFilingStatus(AlabamaIncome::FILING_SINGLE)
            ->withPersonalExemption(false)
            ->withPayPeriods(260)
            ->withFederalIncomeTax($result)
            ->compute();

        $this->assertSame(7.36, $result);
    }
}
