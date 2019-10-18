<?php

namespace Appleton\Taxes\Classes\PayrollLiabilities;

class PayrollLiability
{
    private $tax_class;
    private $amount;
    private $wages;

    public function __construct(string $tax_class, float $amount, int $wages)
    {
        $this->tax_class = $tax_class;
        $this->amount = $amount;
        $this->wages = $wages;
    }

    public function getTaxClass(): string
    {
        return $this->tax_class;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getWages(): int
    {
        return $this->wages;
    }
}
