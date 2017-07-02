<?php

namespace Appleton\Taxes\Countries\US\Alabama\AlabamaIncome;

use Appleton\Taxes\Classes\Taxes;
use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome;
use Appleton\Taxes\Models\TaxInformation;
use Appleton\Taxes\Models\Countries\US\FederalIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\Alabama\AlabamaIncomeTaxInformation;

class AlabamaIncomeTest extends \TestCase
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

        AlabamaIncomeTaxInformation::createForUser([
            'dependents' => 0,
            'filing_status' => AlabamaIncome::FILING_SINGLE,
        ], $this->user);
    }

    public function testAlabamaIncome()
    {
        $result = $this->app->makeWith(AlabamaIncome::class, [
            'earnings' => 66.68,
            'pay_periods' => 260,
            'user' => $this->user,
        ])->compute();

        $this->assertSame(2.07, $result);
    }

    public function testAlabamaIncomeNonNegative()
    {
        $result = $this->app->makeWith(AlabamaIncome::class, [
            'earnings' => 10,
            'pay_periods' => 260,
            'user' => $this->user,
        ])->compute();

        $this->assertSame(0.0, $result);
    }

    public function testAlabamaIncomeWithNoPersonalExemption()
    {
        AlabamaIncomeTaxInformation::forUser($this->user)->update(['filing_status' => AlabamaIncome::FILING_ZERO]);

        $result = $this->app->makeWith(AlabamaIncome::class, [
            'earnings' => 66.68,
            'pay_periods' => 260,
            'user' => $this->user,
        ])->compute();

        $this->assertSame(2.84, $result);
    }
}
