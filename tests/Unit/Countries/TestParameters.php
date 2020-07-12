<?php

namespace Appleton\Taxes\Tests\Unit\Countries;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class TestParameters
{
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
    private $qtd_wages_in_cents;
    private $ytd_liabilities_in_cents;
    private $pay_check_tip_amount_in_cents;
    private $take_home_tip_amount_in_cents;
    private $minutes_worked;
    private $wages_callback;
    private $pay_periods_exempt;
    private $workers_comp_rates;
    private $expected_amounts_in_cents;

    public function __construct(
        string $date,
        ?Carbon $birth_date,
        string $home_location,
        ?string $work_location,
        ?string $tax_info_class,
        ?array $tax_info_options,
        string $tax_class,
        ?array $tax_rate,
        ?string $additional_tax,
        int $wages_in_cents,
        ?int $wtd_wages_in_cents,
        ?int $mtd_wages_in_cents,
        ?int $ytd_wages_in_cents,
        ?int $supplemental_wages_in_cents,
        ?int $expected_amount_in_cents,
        ?int $expected_earnings_in_cents,
        ?int $pay_periods,
        ?int $qtd_wage_in_cents,
        ?int $mtd_liabilities_in_cents,
        ?int $ytd_liabilities_in_cents,
        ?int $pay_check_tip_amount_in_cents,
        ?int $take_home_tip_amount_in_cents,
        ?int $minutes_worked,
        ?callable $wages_callback,
        ?int $pay_periods_exempt,
        ?Collection $workers_comp_rates,
        ?array $expected_amounts_in_cents
    ) {
        $this->date = $date;
        $this->tax_info_class = $tax_info_class;
        $this->tax_info_options = $tax_info_options;
        $this->home_location = $home_location;
        $this->tax_class = $tax_class;
        $this->wages_in_cents = $wages_in_cents;
        $this->wtd_wages_in_cents = $wtd_wages_in_cents;
        $this->mtd_wages_in_cents = $mtd_wages_in_cents;
        $this->ytd_wages_in_cents = $ytd_wages_in_cents;
        $this->expected_amount_in_cents = $expected_amount_in_cents;
        $this->supplemental_wages_in_cents = $supplemental_wages_in_cents;
        $this->pay_periods = $pay_periods;
        $this->work_location = $work_location;
        $this->additional_tax = $additional_tax;
        $this->birth_date = $birth_date;
        $this->expected_earnings_in_cents = $expected_earnings_in_cents;
        $this->tax_rate = $tax_rate;
        $this->qtd_wages_in_cents = $qtd_wage_in_cents;
        $this->mtd_liabilities_in_cents = $mtd_liabilities_in_cents;
        $this->ytd_liabilities_in_cents = $ytd_liabilities_in_cents;
        $this->pay_check_tip_amount_in_cents = $pay_check_tip_amount_in_cents;
        $this->take_home_tip_amount_in_cents = $take_home_tip_amount_in_cents;
        $this->minutes_worked = $minutes_worked;
        $this->wages_callback = $wages_callback;
        $this->pay_periods_exempt = $pay_periods_exempt;
        $this->workers_comp_rates = $workers_comp_rates;
        $this->expected_amounts_in_cents = $expected_amounts_in_cents;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getTaxInfoClass(): ?string
    {
        return $this->tax_info_class;
    }

    public function getTaxInfoOptions(): ?array
    {
        return $this->tax_info_options;
    }

    public function getHomeLocation(): string
    {
        return $this->home_location;
    }

    public function getTaxClass(): string
    {
        return $this->tax_class;
    }

    public function getWagesCallback(): ?callable
    {
        return $this->wages_callback;
    }

    public function getWagesInCents(): int
    {
        return $this->wages_in_cents;
    }

    public function getWtdWagesInCents(): ?int
    {
        return $this->wtd_wages_in_cents;
    }

    public function getMtdWagesInCents(): ?int
    {
        return $this->mtd_wages_in_cents;
    }

    public function getYtdWagesInCents(): ?int
    {
        return $this->ytd_wages_in_cents;
    }

    public function getExpectedAmountInCents(): ?int
    {
        return $this->expected_amount_in_cents;
    }

    public function getSupplementalWagesInCents(): ?int
    {
        return $this->supplemental_wages_in_cents;
    }

    public function getPayPeriods(): ?int
    {
        return $this->pay_periods;
    }

    public function getWorkLocation(): ?string
    {
        return $this->work_location;
    }

    public function getAdditionalTax(): ?string
    {
        return $this->additional_tax;
    }

    public function getBirthDate(): ?Carbon
    {
        return $this->birth_date;
    }

    public function getExpectedEarningsInCents(): ?int
    {
        return $this->expected_earnings_in_cents;
    }

    public function getTaxRate(): ?array
    {
        return $this->tax_rate;
    }

    public function getQtdWagesInCents(): ?int
    {
        return $this->qtd_wages_in_cents;
    }

    public function getMtdLiabilitiesInCents(): ?int
    {
        return $this->mtd_liabilities_in_cents;
    }

    public function getYtdLiabilitiesInCents(): ?int
    {
        return $this->ytd_liabilities_in_cents;
    }

    public function getPayPeriodsCount(): ?int
    {
        return $this->pay_periods_exempt;
    }

    public function getPaycheckTipAmountInCents(): ?int
    {
        return $this->pay_check_tip_amount_in_cents;
    }

    public function getTakeHomeTipAmountInCents(): ?int
    {
        return $this->take_home_tip_amount_in_cents;
    }

    public function getMinutesWorked(): ?int
    {
        return $this->minutes_worked;
    }

    public function getWorkersCompRates(): ?Collection
    {
        return $this->workers_comp_rates;
    }

    public function getExpectedAmountsInCents(): ?array
    {
        return $this->expected_amounts_in_cents;
    }
}
