<?php

namespace Appleton\Taxes\Tests\Unit\Countries;

class UnemploymentTaxTestCase extends WageBaseTaxTestCase
{
    public function validateWorkDifferentState(
        string $date,
        string $location,
        string $tax_class,
        string $tax_rate
    ): void
    {
        $this->validateWageBase(
            (new TestParametersBuilder())
                ->setDate($date)
                ->setHomeLocation($location)
                ->setWorkLocation('us.alabama')
                ->setTaxClass($tax_class)
                ->setWagesInCents(1000)
                ->setYtdLiabilitiesInCents(null)
                ->setExpectedAmountInCents($this->calculate(1000, $tax_rate))
                ->setExpectedEarningsInCents(1000)
                ->build()
        );
    }

    public function validateTaxRate(
        string $date,
        string $location,
        string $tax_class,
        string $tax_rate
    ): void
    {
        $this->validateWageBase(
            (new TestParametersBuilder())
                ->setDate($date)
                ->setHomeLocation($location)
                ->setTaxClass($tax_class)
                ->setWagesInCents(230000)
                ->setYtdLiabilitiesInCents(null)
                ->setExpectedAmountInCents($this->calculate(230000, $tax_rate))
                ->setExpectedEarningsInCents(230000)
                ->setTaxRate(['taxes.rates.'.$location.'.unemployment' => $tax_rate])
                ->build()
        );
    }

    public function roundedValidateWorkDifferentState(
        string $date,
        string $location,
        string $tax_class,
        string $tax_rate
    ): void
    {
        $this->validateWageBase(
            (new TestParametersBuilder())
                ->setDate($date)
                ->setHomeLocation($location)
                ->setWorkLocation('us.alabama')
                ->setTaxClass($tax_class)
                ->setWagesInCents(10000)
                ->setYtdLiabilitiesInCents(null)
                ->setExpectedAmountInCents($this->roundToDollar($this->calculate(10000, $tax_rate)))
                ->setExpectedEarningsInCents(10000)
                ->build()
        );
    }

    public function roundedValidateTaxRate(
        string $date,
        string $location,
        string $tax_class,
        string $tax_rate
    ): void
    {
        $this->validateWageBase(
            (new TestParametersBuilder())
                ->setDate($date)
                ->setHomeLocation($location)
                ->setTaxClass($tax_class)
                ->setWagesInCents(230000)
                ->setYtdLiabilitiesInCents(null)
                ->setExpectedAmountInCents($this->roundToDollar($this->calculate(230000, $tax_rate)))
                ->setExpectedEarningsInCents(230000)
                ->setTaxRate(['taxes.rates.'.$location.'.unemployment' => $tax_rate])
                ->build()
        );
    }
}
