<?php

namespace Appleton\Taxes\Tests\Unit\Countries;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class TestParametersBuilder
{
    private const STATES = [
        'AL', 'AK', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'FL', 'GA', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA',
        'ME', 'MD', 'MA', 'MI', 'MN', 'MS', 'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'OH', 'OK',
        'OR', 'PA', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VA', 'WA', 'DC', 'WV', 'WI', 'WY'
    ];

    private $date;
    private $birth_date;
    private $home_location;
    private $work_location;
    private $tax_class;
    private $tax_info_class;
    private $tax_info_options;
    private $pay_periods;
    private $additional_tax;
    private $tax_rate;
    private $wages_in_cents;
    private $wtd_wages_in_cents;
    private $mtd_wages_in_cents;
    private $ytd_wages_in_cents;
    private $supplemental_wages_in_cents;
    private $expected_amount_in_cents;
    private $expected_earnings_in_cents;
    private $mtd_liabilities_in_cents;
    private $qtd_wage_in_cents;
    private $ytd_liabilities_in_cents;
    private $pay_check_tip_amount_in_cents;
    private $take_home_tip_amount_in_cents;
    private $minutes_worked;
    private $wages_callback;
    private $pay_periods_exempt;
    private $workers_comp_rates;
    private $expected_amounts_in_cents;
    private $suta_rates;

    public function __construct()
    {
        $this->suta_rates = collect([]);
        collect(self::STATES)->each(function (string $state) {
            $this->suta_rates->put($state, 0);
        });
    }


    public function build(): TestParameters
    {
        return new TestParameters(
            $this->date,
            $this->birth_date,
            $this->home_location,
            $this->work_location,
            $this->tax_info_class,
            $this->tax_info_options,
            $this->tax_class,
            $this->tax_rate,
            $this->additional_tax,
            $this->wages_in_cents,
            $this->wtd_wages_in_cents,
            $this->mtd_wages_in_cents,
            $this->ytd_wages_in_cents,
            $this->supplemental_wages_in_cents,
            $this->expected_amount_in_cents,
            $this->expected_earnings_in_cents,
            $this->pay_periods,
            $this->qtd_wage_in_cents,
            $this->mtd_liabilities_in_cents,
            $this->ytd_liabilities_in_cents,
            $this->pay_check_tip_amount_in_cents,
            $this->take_home_tip_amount_in_cents,
            $this->minutes_worked,
            $this->wages_callback,
            $this->pay_periods_exempt,
            $this->workers_comp_rates ?? collect([]),
            $this->expected_amounts_in_cents,
            $this->suta_rates
        );
    }

    public function setDate(string $date)
    {
        $this->date = $date;
        return $this;
    }

    public function setTaxInfoClass(?string $tax_info_class)
    {
        $this->tax_info_class = $tax_info_class;
        return $this;
    }

    public function setTaxInfoOptions(?array $tax_info_options)
    {
        $this->tax_info_options = $tax_info_options;
        return $this;
    }

    public function setHomeLocation(string $home_location)
    {
        $this->home_location = $home_location;
        return $this;
    }

    public function setWorkLocation(?string $work_location)
    {
        $this->work_location = $work_location;
        return $this;
    }

    public function setTaxClass(?string $tax_class)
    {
        $this->tax_class = $tax_class;
        return $this;
    }

    public function setWagesInCents(?int $wages_in_cents)
    {
        $this->wages_in_cents = $wages_in_cents;
        return $this;
    }

    public function setWtdWagesInCents(?int $wtd_wages_in_cents)
    {
        $this->wtd_wages_in_cents = $wtd_wages_in_cents;
        return $this;
    }

    public function setMtdWagesInCents(?int $mtd_wages_in_cents)
    {
        $this->mtd_wages_in_cents = $mtd_wages_in_cents;
        return $this;
    }

    public function setYtdWagesInCents(?int $ytd_wages_in_cents)
    {
        $this->ytd_wages_in_cents = $ytd_wages_in_cents;
        return $this;
    }

    public function setExpectedAmountInCents(?int $expected_amount_in_cents)
    {
        $this->expected_amount_in_cents = $expected_amount_in_cents;
        return $this;
    }

    public function setExpectedAmountsInCents(?array $expected_amounts_in_cents)
    {
        $this->expected_amounts_in_cents = $expected_amounts_in_cents;
        return $this;
    }

    public function setSupplementalWagesInCents(?int $supplemental_wages_in_cents)
    {
        $this->supplemental_wages_in_cents = $supplemental_wages_in_cents;
        return $this;
    }

    public function setPayPeriods(?int $pay_periods)
    {
        $this->pay_periods = $pay_periods;
        return $this;
    }

    public function setAdditionalTax(?string $additional_tax)
    {
        $this->additional_tax = $additional_tax;
        return $this;
    }

    public function setBirthDate(?Carbon $birth_date)
    {
        $this->birth_date = $birth_date;
        return $this;
    }

    public function setExpectedEarningsInCents(?int $expected_earnings_in_cents)
    {
        $this->expected_earnings_in_cents = $expected_earnings_in_cents;
        return $this;
    }

    public function setTaxRate(?array $tax_rate)
    {
        $this->tax_rate = $tax_rate;
        return $this;
    }

    public function setQtdWageInCents(?int $qtd_wage_in_cents)
    {
        $this->qtd_wage_in_cents = $qtd_wage_in_cents;
        return $this;
    }

    public function setMtdLiabilitiesInCents(?int $mtd_liabilities_in_cents)
    {
        $this->mtd_liabilities_in_cents = $mtd_liabilities_in_cents;
        return $this;
    }

    public function setYtdLiabilitiesInCents(?int $ytd_liabilities_in_cents)
    {
        $this->ytd_liabilities_in_cents = $ytd_liabilities_in_cents;
        return $this;
    }

    public function setPayPeriodsExempt(?int $pay_periods_exempt)
    {
        $this->pay_periods_exempt = $pay_periods_exempt;
        return $this;
    }

    public function setPaycheckTipAmount(?int $pay_check_tip_amount_in_cents)
    {
        $this->pay_check_tip_amount_in_cents = $pay_check_tip_amount_in_cents;
        return $this;
    }

    public function setTakeHomeTipAmount(?int $take_home_tip_amount_in_cents)
    {
        $this->take_home_tip_amount_in_cents = $take_home_tip_amount_in_cents;
        return $this;
    }

    public function setMinutesWorked(?int $minutes_worked)
    {
        $this->minutes_worked = $minutes_worked;
        return $this;
    }

    public function setWagesCallback(?callable $wages_callback)
    {
        $this->wages_callback = $wages_callback;
        return $this;
    }

    public function setWorkersCompRates(?Collection $workers_comp_rates)
    {
        $this->workers_comp_rates = $workers_comp_rates;
        return $this;
    }

    public function addSutaRate(string $state, float $percent)
    {
        $this->suta_rates->put($state, $percent);
        return $this;
    }
}
