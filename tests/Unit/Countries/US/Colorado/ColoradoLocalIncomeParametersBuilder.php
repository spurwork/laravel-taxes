<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Colorado;

class ColoradoLocalIncomeParametersBuilder
{
    private $date;
    private $local_location;
    private $tax_class;
    private $local_earnings_in_cents;
    private $local_mtd_liabilities_in_cents;
    private $colorado_earnings_in_cents;
    private $colorado_mtd_liabilities_in_cents;
    private $expected_amount_in_cents;

    public function build(): ColoradoLocalIncomeParameters
    {
        return new ColoradoLocalIncomeParameters(
            $this->date,
            $this->local_location,
            $this->tax_class,
            $this->local_earnings_in_cents,
            $this->local_mtd_liabilities_in_cents,
            $this->colorado_earnings_in_cents,
            $this->colorado_mtd_liabilities_in_cents,
            $this->expected_amount_in_cents
        );
    }

    public function setDate(string $date)
    {
        $this->date = $date;
        return $this;
    }

    public function setLocalLocation(string $local_location)
    {
        $this->local_location = $local_location;
        return $this;
    }

    public function setTaxClass(string $tax_class)
    {
        $this->tax_class = $tax_class;
        return $this;
    }

    public function setLocalEarningsInCents(int $local_earnings_in_cents)
    {
        $this->local_earnings_in_cents = $local_earnings_in_cents;
        return $this;
    }

    public function setLocalMtdLiabilitiesInCents(int $local_mtd_liabilities_in_cents)
    {
        $this->local_mtd_liabilities_in_cents = $local_mtd_liabilities_in_cents;
        return $this;
    }

    public function setColoradoEarningsInCents(int $colorado_earnings_in_cents)
    {
        $this->colorado_earnings_in_cents = $colorado_earnings_in_cents;
        return $this;
    }

    public function setColoradoMtdLiabilitiesInCents(int $colorado_mtd_liabilities_in_cents)
    {
        $this->colorado_mtd_liabilities_in_cents = $colorado_mtd_liabilities_in_cents;
        return $this;
    }

    public function setExpectedAmountInCents(?int $expected_amount_in_cents)
    {
        $this->expected_amount_in_cents = $expected_amount_in_cents;
        return $this;
    }
}
