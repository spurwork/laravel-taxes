<?php

namespace Appleton\Taxes\Tests\Unit\Countries;

use Carbon\Carbon;

class IncomeParametersBuilder
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

    public function build(): IncomeParameters
    {
        return new IncomeParameters(
            $this->date,
            $this->tax_info_class,
            $this->tax_info_options,
            $this->home_location,
            $this->work_location,
            $this->tax_class,
            $this->wages_in_cents,
            $this->ytd_wages_in_cents,
            $this->supplemental_wages_in_cents,
            $this->pay_periods,
            $this->expected_amount_in_cents,
            $this->additional_tax,
            $this->birth_date
        );
    }

    public function setDate(?string $date)
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

    public function setHomeLocation(?string $home_location)
    {
        $this->home_location = $home_location;
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

    public function setWorkLocation(?string $work_location)
    {
        $this->work_location = $work_location;
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
}
