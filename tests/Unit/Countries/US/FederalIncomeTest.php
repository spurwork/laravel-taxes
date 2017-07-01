<?php

namespace Appleton\Taxes\Countries\US;

use Appleton\Taxes\Classes\Taxes;
use Appleton\Taxes\Models\TaxInformation;
use Appleton\Taxes\Models\Countries\US\FederalIncomeTaxInformation;

class FederalIncomeTest extends \TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->user = $this->user_model->forceCreate([
            'name' => 'Test User',
            'email' => 'test@user.email',
            'password' => 'password',
        ]);

        FederalIncomeTaxInformation::createForUser([
            'exemptions' => 0,
            'filing_status' => FederalIncome::FILING_SINGLE,
            'non_resident_alien' => false,
        ], $this->user);
    }

    public function testFederalIncome()
    {
        $result = $this->app->make(FederalIncome::class, [
            'earnings' => 2300,
            'pay_periods' => 1,
            'user' => $this->user,
        ])->compute();

        $this->assertSame(0.0, $result);
    }

    public function testNoTaxesOwed()
    {
        $result = $this->app->make(FederalIncome::class, [
            'earnings' => 2300,
            'pay_periods' => 1,
            'user' => $this->user,
        ])->compute();

        $this->assertSame(0.0, $result);

        FederalIncomeTaxInformation::forUser($this->user)->update(['filing_status' => FederalIncome::FILING_MARRIED]);

        $result = $this->app->make(FederalIncome::class, [
            'earnings' => 8650,
            'pay_periods' => 1,
            'user' => $this->user,
        ])->compute();

        $this->assertSame(0.0, $result);
    }

    public function testTaxesOwed()
    {
        $result = $this->app->make(FederalIncome::class, [
            'earnings' => 2301,
            'pay_periods' => 1,
            'user' => $this->user,
        ])->compute();

        $this->assertSame(0.10, $result);

        FederalIncomeTaxInformation::forUser($this->user)->update(['filing_status' => FederalIncome::FILING_MARRIED]);

        $result = $this->app->make(FederalIncome::class, [
            'earnings' => 8651,
            'pay_periods' => 1,
            'user' => $this->user,
        ])->compute();

        $this->assertSame(0.10, $result);
    }

    public function testWeekly()
    {
        $result = $this->app->make(FederalIncome::class, [
            'earnings' => 2300,
            'pay_periods' => 52,
            'user' => $this->user,
        ])->compute();

        $this->assertSame(496.65, $result);
    }

    public function testBimonthly()
    {
        $result = $this->app->make(FederalIncome::class, [
            'earnings' => 2300,
            'pay_periods' => 24,
            'user' => $this->user,
        ])->compute();

        $this->assertSame(373.49, $result);
    }

    public function testMonthly()
    {
        $result = $this->app->make(FederalIncome::class, [
            'earnings' => 2300,
            'pay_periods' => 12,
            'user' => $this->user,
        ])->compute();

        $this->assertSame(277.40, $result);
    }

    public function testCaseStudy1()
    {
        $result = $this->app->make(FederalIncome::class, [
            'earnings' => 66.68,
            'pay_periods' => 260,
            'user' => $this->user,
        ])->compute();

        $this->assertSame(6.88, $result);
    }

    public function testNonNegative()
    {
        $result = $this->app->make(FederalIncome::class, [
            'earnings' => 10,
            'pay_periods' => 260,
            'user' => $this->user,
        ])->compute();

        $this->assertSame(0.12, $result);
    }
}
