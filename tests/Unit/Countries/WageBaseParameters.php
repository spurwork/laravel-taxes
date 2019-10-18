<?php

namespace Appleton\Taxes\Tests\Unit\Countries;

class WageBaseParameters
{
    private $date;
    private $home_location;
    private $work_location;
    private $tax_class;
    private $wages_in_cents;
    private $ytd_wages_in_cents;
    private $expected_amount_in_cents;
    private $tax_rate;

    public function __construct(string $date,
                                string $home_location,
                                ?string $work_location,
                                string $tax_class,
                                int $wages_in_cents,
                                ?int $ytd_wages_in_cents,
                                ?int $expected_amount_in_cents,
                                ?array $tax_rate)
    {
        $this->date = $date;
        $this->home_location = $home_location;
        $this->work_location = $work_location;
        $this->tax_class = $tax_class;
        $this->wages_in_cents = $wages_in_cents;
        $this->ytd_wages_in_cents = $ytd_wages_in_cents;
        $this->expected_amount_in_cents = $expected_amount_in_cents;
        $this->tax_rate = $tax_rate;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getHomeLocation(): string
    {
        return $this->home_location;
    }

    public function getWorkLocation(): ?string
    {
        return $this->work_location;
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

    public function getTaxRate(): ?array
    {
        return $this->tax_rate;
    }
}
