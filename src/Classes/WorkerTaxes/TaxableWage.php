<?php

namespace Appleton\Taxes\Classes\WorkerTaxes;

use Carbon\Carbon;

class TaxableWage
{
    private $amount;
    private $date;
    private $tax_class;

    public function __construct(int $amount, Carbon $date, string $tax_class)
    {
        $this->amount = $amount;
        $this->date = $date;
        $this->tax_class = $tax_class;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getDate(): Carbon
    {
        return $this->date;
    }

    public function getTaxClass(): string
    {
        return $this->tax_class;
    }
}
