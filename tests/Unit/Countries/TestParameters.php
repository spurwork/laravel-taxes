<?php

namespace Appleton\Taxes\Tests\Unit\Countries;

use Carbon\Carbon;

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
    private $ytd_wages_in_cents;
    private $supplemental_wages_in_cents;
    private $expected_amount_in_cents;
    private $expected_earnings_in_cents;
    private $qtd_wages_in_cents;
    private $ytd_liabilities_in_cents;
    private $pay_rate;

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
        ?int $ytd_wages_in_cents,
        ?int $supplemental_wages_in_cents,
        ?int $expected_amount_in_cents,
        ?int $expected_earnings_in_cents,
        ?int $pay_periods,
        ?int $qtd_wage_in_cents,
        ?int $ytd_liabilities_in_cents,
        ?int $pay_rate
    ) {
        $this->date = $date;
        $this->tax_info_class = $tax_info_class;
        $this->tax_info_options = $tax_info_options;
        $this->home_location = $home_location;
        $this->tax_class = $tax_class;
        $this->wages_in_cents = $wages_in_cents;
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
        $this->ytd_liabilities_in_cents = $ytd_liabilities_in_cents;
        $this->pay_rate = $pay_rate;
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

    public function getWagesInCents(): int
    {
        return $this->wages_in_cents;
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

    public function getYtdLiabilitiesInCents(): ?int
    {
        return $this->ytd_liabilities_in_cents;
    }

    public function getPayRate(): ?int
    {
        return $this->pay_rate;
    }
}
