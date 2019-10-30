<?php

namespace Appleton\Taxes\Classes\WorkerTaxes;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class Wage
{
    private $location;
    private $amount_in_cents;
    private $pay_check_tip_amount_in_cents;
    private $take_home_tip_amount_in_cents;
    private $pay_rate_per_hour_in_cents;
    private $type;
    private $date;
    private $additional_taxes;

    public function __construct(
        string $type,
        Carbon $date,
        GeoPoint $location,
        int $amount_in_cents,
        int $pay_check_tip_amount_in_cents,
        int $take_home_tip_amount_in_cents,
        int $pay_rate_per_hour_in_cents,
        Collection $additional_taxes)
    {
        $this->type = $type;
        $this->date = $date;
        $this->location = $location;
        $this->amount_in_cents = $amount_in_cents;
        $this->pay_check_tip_amount_in_cents = $pay_check_tip_amount_in_cents;
        $this->take_home_tip_amount_in_cents = $take_home_tip_amount_in_cents;
        $this->pay_rate_per_hour_in_cents = $pay_rate_per_hour_in_cents;
        $this->additional_taxes = $additional_taxes;
    }

    public function getLocation(): GeoPoint
    {
        return $this->location;
    }

    public function getAmountInCents(): int
    {
        return $this->amount_in_cents;
    }

    public function getPayCheckTipAmountInCents(): int
    {
        return $this->pay_check_tip_amount_in_cents;
    }

    public function getTakeHomeTipAmountInCents(): int
    {
        return $this->take_home_tip_amount_in_cents;
    }

    public function getPayRatePerHourInCents(): int
    {
        return $this->pay_rate_per_hour_in_cents;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getDate(): Carbon
    {
        return $this->date;
    }

    public function getAdditionalTaxes(): Collection
    {
        return $this->additional_taxes;
    }
}