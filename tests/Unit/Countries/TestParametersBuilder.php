<?php

namespace Appleton\Taxes\Tests\Unit\Countries;

use Carbon\Carbon;
use Closure;
use Illuminate\Support\Collection;

class TestParametersBuilder
{
    private const STATES = [
        'AL', 'AK', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'FL', 'GA', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA',
        'ME', 'MD', 'MA', 'MI', 'MN', 'MS', 'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'OH', 'OK',
        'OR', 'PA', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VA', 'WA', 'DC', 'WV', 'WI', 'WY'
    ];

    private string $date;
    private ?Carbon $birth_date = null;
    private string $home_location;
    private ?string $work_location = null;
    private ?string $tax_class = null;
    private ?string $tax_info_class = null;
    private ?array $tax_info_options = null;
    private ?int $pay_periods = null;
    private ?int $additional_tax = null;
    private ?array $tax_rate = null;
    private ?int $wages_in_cents = null;
    private ?int $wtd_wages_in_cents = null;
    private ?int $mtd_wages_in_cents = null;
    private ?int $ytd_wages_in_cents = null;
    private ?int $supplemental_wages_in_cents = null;
    private ?int $expected_amount_in_cents = null;
    private ?int $expected_earnings_in_cents = null;
    private ?int $mtd_liabilities_in_cents = null;
    private ?int $qtd_wage_in_cents = null;
    private ?int $ytd_liabilities_in_cents = null;
    private ?int $pay_check_tip_amount_in_cents = null;
    private ?int $take_home_tip_amount_in_cents = null;
    private ?int $minutes_worked = null;
    private ?Closure $wages_callback = null;
    private ?int $pay_periods_exempt = null;
    private ?Collection $workers_comp_rates = null;
    private ?array $expected_amounts_in_cents = null;
    private Collection $suta_rates;

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

    public function setDate(string $date): static
    {
        $this->date = $date;
        return $this;
    }

    public function setTaxInfoClass(?string $tax_info_class): static
    {
        $this->tax_info_class = $tax_info_class;
        return $this;
    }

    public function setTaxInfoOptions(?array $tax_info_options): static
    {
        $this->tax_info_options = $tax_info_options;
        return $this;
    }

    public function setHomeLocation(string $home_location): static
    {
        $this->home_location = $home_location;
        return $this;
    }

    public function setWorkLocation(?string $work_location): static
    {
        $this->work_location = $work_location;
        return $this;
    }

    public function setTaxClass(?string $tax_class): static
    {
        $this->tax_class = $tax_class;
        return $this;
    }

    public function setWagesInCents(?int $wages_in_cents): static
    {
        $this->wages_in_cents = $wages_in_cents;
        return $this;
    }

    public function setWtdWagesInCents(?int $wtd_wages_in_cents): static
    {
        $this->wtd_wages_in_cents = $wtd_wages_in_cents;
        return $this;
    }

    public function setMtdWagesInCents(?int $mtd_wages_in_cents): static
    {
        $this->mtd_wages_in_cents = $mtd_wages_in_cents;
        return $this;
    }

    public function setYtdWagesInCents(?int $ytd_wages_in_cents): static
    {
        $this->ytd_wages_in_cents = $ytd_wages_in_cents;
        return $this;
    }

    public function setExpectedAmountInCents(?int $expected_amount_in_cents): static
    {
        $this->expected_amount_in_cents = $expected_amount_in_cents;
        return $this;
    }

    public function setExpectedAmountsInCents(?array $expected_amounts_in_cents): static
    {
        $this->expected_amounts_in_cents = $expected_amounts_in_cents;
        return $this;
    }

    public function setSupplementalWagesInCents(?int $supplemental_wages_in_cents): static
    {
        $this->supplemental_wages_in_cents = $supplemental_wages_in_cents;
        return $this;
    }

    public function setPayPeriods(?int $pay_periods): static
    {
        $this->pay_periods = $pay_periods;
        return $this;
    }

    public function setAdditionalTax(?string $additional_tax): static
    {
        $this->additional_tax = $additional_tax;
        return $this;
    }

    public function setBirthDate(?Carbon $birth_date): static
    {
        $this->birth_date = $birth_date;
        return $this;
    }

    public function setExpectedEarningsInCents(?int $expected_earnings_in_cents): static
    {
        $this->expected_earnings_in_cents = $expected_earnings_in_cents;
        return $this;
    }

    public function setTaxRate(?array $tax_rate): static
    {
        $this->tax_rate = $tax_rate;
        return $this;
    }

    public function setQtdWageInCents(?int $qtd_wage_in_cents): static
    {
        $this->qtd_wage_in_cents = $qtd_wage_in_cents;
        return $this;
    }

    public function setMtdLiabilitiesInCents(?int $mtd_liabilities_in_cents): static
    {
        $this->mtd_liabilities_in_cents = $mtd_liabilities_in_cents;
        return $this;
    }

    public function setYtdLiabilitiesInCents(?int $ytd_liabilities_in_cents): static
    {
        $this->ytd_liabilities_in_cents = $ytd_liabilities_in_cents;
        return $this;
    }

    public function setPayPeriodsExempt(?int $pay_periods_exempt): static
    {
        $this->pay_periods_exempt = $pay_periods_exempt;
        return $this;
    }

    public function setPaycheckTipAmount(?int $pay_check_tip_amount_in_cents): static
    {
        $this->pay_check_tip_amount_in_cents = $pay_check_tip_amount_in_cents;
        return $this;
    }

    public function setTakeHomeTipAmount(?int $take_home_tip_amount_in_cents): static
    {
        $this->take_home_tip_amount_in_cents = $take_home_tip_amount_in_cents;
        return $this;
    }

    public function setMinutesWorked(?int $minutes_worked): static
    {
        $this->minutes_worked = $minutes_worked;
        return $this;
    }

    public function setWagesCallback(?callable $wages_callback): static
    {
        $this->wages_callback = $wages_callback;
        return $this;
    }

    public function setWorkersCompRates(?Collection $workers_comp_rates): static
    {
        $this->workers_comp_rates = $workers_comp_rates;
        return $this;
    }

    public function addSutaRate(string $state, float $percent): static
    {
        $this->suta_rates->put($state, $percent);
        return $this;
    }
}
