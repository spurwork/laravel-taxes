<?php

namespace Appleton\Taxes\Tests\Unit\Countries;

use Carbon\Carbon;

class IncomeParameters
{
    private $date;
    private $tax_info_class;
    private $tax_info_options;
    private $home_location;
    private $tax_class;
    private $wages_in_cents;
    private $ytd_wages_in_cents;
    private $expected_amount_in_cents;
    private $supplemental_wages_in_cents;
    private $pay_periods;
    private $work_location;
    private $additional_tax;
    private $birth_date;

    public function __construct(string $date,
                                ?string $tax_info_class,
                                ?array $tax_info_options,
                                string $home_location,
                                ?string $work_location,
                                string $tax_class,
                                int $wages_in_cents,
                                ?int $ytd_wages_in_cents,
                                ?int $supplemental_wages_in_cents,
                                int $pay_periods,
                                ?int $expected_amount_in_cents,
                                ?string $additional_tax,
                                ?Carbon $birth_date)
    {
        $this->date = $date;
        $this->tax_info_class = $tax_info_class;
        $this->tax_info_options = $tax_info_options;
        $this->home_location = $home_location;
        $this->work_location = $work_location;
        $this->tax_class = $tax_class;
        $this->wages_in_cents = $wages_in_cents;
        $this->ytd_wages_in_cents = $ytd_wages_in_cents;
        $this->expected_amount_in_cents = $expected_amount_in_cents;
        $this->pay_periods = $pay_periods;
        $this->supplemental_wages_in_cents = $supplemental_wages_in_cents;
        $this->additional_tax = $additional_tax;
        $this->birth_date = $birth_date;
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

    public function getPayPeriods(): int
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
}
