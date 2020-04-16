<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Colorado;

class ColoradoLocalIncomeParameters
{
    private $date;
    private $local_location;
    private $tax_class;
    private $local_earnings_in_cents;
    private $local_mtd_earnings_in_cents;
    private $colorado_earnings_in_cents;
    private $colorado_mtd_liabilities_in_cents;
    private $expected_amount_in_cents;

    public function __construct(
        string $date,
        string $local_location,
        string $tax_class,
        int $local_earnings_in_cents,
        int $local_mtd_liabilities_in_cents,
        int $colorado_earnings_in_cents,
        int $colorado_mtd_liabilities_in_cents,
        ?int $expected_amount_in_cents
    ) {
        $this->date = $date;
        $this->local_location = $local_location;
        $this->tax_class = $tax_class;
        $this->local_earnings_in_cents = $local_earnings_in_cents;
        $this->local_mtd_earnings_in_cents = $local_mtd_liabilities_in_cents;
        $this->colorado_earnings_in_cents = $colorado_earnings_in_cents;
        $this->colorado_mtd_liabilities_in_cents = $colorado_mtd_liabilities_in_cents;
        $this->expected_amount_in_cents = $expected_amount_in_cents;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getLocalLocation(): string
    {
        return $this->local_location;
    }

    public function getTaxClass(): string
    {
        return $this->tax_class;
    }

    public function getLocalEarningsInCents(): int
    {
        return $this->local_earnings_in_cents;
    }

    public function getLocalMtdEarningsInCents(): int
    {
        return $this->local_mtd_earnings_in_cents;
    }

    public function getColoradoEarningsInCents(): int
    {
        return $this->colorado_earnings_in_cents;
    }

    public function getColoradoMtdLiabilitiesInCents(): int
    {
        return $this->colorado_mtd_liabilities_in_cents;
    }

    public function getExpectedAmountInCents(): ?int
    {
        return $this->expected_amount_in_cents;
    }
}
