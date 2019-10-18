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
            (new WageBaseParametersBuilder())
                ->setDate($date)
                ->setHomeLocation($location)
                ->setWorkLocation('us.alabama')
                ->setTaxClass($tax_class)
                ->setWagesInCents(1000)
                ->setYtdWagesInCents(null)
                ->setExpectedAmountInCents($this->calculate(1000, $tax_rate))
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
            (new WageBaseParametersBuilder())
                ->setDate($date)
                ->setHomeLocation($location)
                ->setTaxClass($tax_class)
                ->setWagesInCents(230000)
                ->setYtdWagesInCents(null)
                ->setExpectedAmountInCents($this->calculate(230000, $tax_rate))
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
            (new WageBaseParametersBuilder())
                ->setDate($date)
                ->setHomeLocation($location)
                ->setWorkLocation('us.alabama')
                ->setTaxClass($tax_class)
                ->setWagesInCents(10000)
                ->setYtdWagesInCents(null)
                ->setExpectedAmountInCents($this->roundToDollar($this->calculate(10000, $tax_rate)))
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
            (new WageBaseParametersBuilder())
                ->setDate($date)
                ->setHomeLocation($location)
                ->setTaxClass($tax_class)
                ->setWagesInCents(230000)
                ->setYtdWagesInCents(null)
                ->setExpectedAmountInCents($this->roundToDollar($this->calculate(230000, $tax_rate)))
                ->setTaxRate(['taxes.rates.'.$location.'.unemployment' => $tax_rate])
                ->build()
        );
    }
}
