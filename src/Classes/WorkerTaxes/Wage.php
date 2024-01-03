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
    private $minutes_worked;
    private $type;
    private $date;
    private $additional_taxes;
    private $position;
    private $is_overtime;

    public function __construct(
        string $type,
        Carbon $date,
        GeoPoint $location,
        int $amount_in_cents,
        int $pay_check_tip_amount_in_cents,
        int $take_home_tip_amount_in_cents,
        int $minutes_worked,
        Collection $additional_taxes,
        int $position = null,
        bool $is_overtime = false,
    ) {
        $this->type = $type;
        $this->date = $date;
        $this->location = $location;
        $this->amount_in_cents = $amount_in_cents;
        $this->pay_check_tip_amount_in_cents = $pay_check_tip_amount_in_cents;
        $this->take_home_tip_amount_in_cents = $take_home_tip_amount_in_cents;
        $this->minutes_worked = $minutes_worked;
        $this->additional_taxes = $additional_taxes;
        $this->position = $position;
        $this->is_overtime = $is_overtime;
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

    public function getWorkTimeInMinutes(): int
    {
        return $this->minutes_worked;
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

    public function getPosition(): int
    {
        return $this->position;
    }

    public function isOvertime(): bool
    {
        return $this->is_overtime;
    }
}
