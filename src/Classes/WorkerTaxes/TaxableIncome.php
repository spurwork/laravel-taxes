<?php

namespace Appleton\Taxes\Classes\WorkerTaxes;

use Appleton\Taxes\Models\Tax;
use Illuminate\Support\Collection;

class TaxableIncome
{
    private $tax;
    private $wages;
    private $historical_wages;
    private $exemption_amount_in_cents;

    public function __construct(
        Tax $tax,
        Collection $wages,
        Collection $historical_wages,
        int $exemption_amount_in_cents)
    {
        $this->tax = $tax;
        $this->wages = $wages;
        $this->historical_wages = $historical_wages;
        $this->exemption_amount_in_cents = $exemption_amount_in_cents;
    }

    public function getTax(): Tax
    {
        return $this->tax;
    }

    public function getExemptionAmountInCents(): float
    {
        return $this->exemption_amount_in_cents;
    }

    public function getWages(): Collection
    {
        return $this->wages;
    }

    public function getHistoricalWages(): Collection
    {
        return $this->historical_wages;
    }
}
