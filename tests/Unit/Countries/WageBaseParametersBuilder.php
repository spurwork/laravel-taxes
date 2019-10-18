<?php

namespace Appleton\Taxes\Tests\Unit\Countries;

class WageBaseParametersBuilder
{
    private $date;
    private $home_location;
    private $work_location;
    private $tax_class;
    private $wages_in_cents;
    private $ytd_wages_in_cents;
    private $expected_amount_in_cents;
    private $tax_rate;

    public function build(): WageBaseParameters
    {
        return new WageBaseParameters(
            $this->date,
            $this->home_location,
            $this->work_location,
            $this->tax_class,
            $this->wages_in_cents,
            $this->ytd_wages_in_cents,
            $this->expected_amount_in_cents,
            $this->tax_rate
        );
    }

    public function setDate(?string $date)
    {
        $this->date = $date;
        return $this;
    }

    public function setHomeLocation(?string $home_location)
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

    public function setTaxRate(?array $tax_rate)
    {
        $this->tax_rate = $tax_rate;
        return $this;
    }
}
