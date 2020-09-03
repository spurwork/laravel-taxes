<?php

namespace Appleton\Taxes\Classes\WorkerTaxes;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseTax;

class TaxResult
{
    private $tax_class;
    private $tax_name;
    private $tax;
    private $amount_in_cents;
    private $earnings_in_cents;
    private $workers_comp_rate_id;

    public function __construct(
        string $tax_class,
        string $tax_name,
        BaseTax $tax,
        int $amount_in_cents,
        int $earnings_in_cents,
        ?int $workers_comp_rate_id
    ) {
        $this->tax_class = $tax_class;
        $this->tax_name = $tax_name;
        $this->tax = $tax;
        $this->amount_in_cents = $amount_in_cents;
        $this->earnings_in_cents = $earnings_in_cents;
        $this->workers_comp_rate_id = $workers_comp_rate_id;
    }

    public function getTaxClass(): string
    {
        return $this->tax_class;
    }

    public function getTaxName(): string
    {
        return $this->tax_name;
    }

    public function getTax(): BaseTax
    {
        return $this->tax;
    }

    public function getAmountInCents(): int
    {
        return $this->amount_in_cents;
    }

    public function getEarningsInCents(): int
    {
        return $this->earnings_in_cents;
    }
}
