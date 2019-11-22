<?php

namespace Appleton\Taxes\Tests\Unit\Countries;

use Appleton\Taxes\Classes\WorkerTaxes\GeoPoint;
use Appleton\Taxes\Classes\WorkerTaxes\TaxOverrideManager;
use Illuminate\Support\Collection;

class TestTaxOverrideManager extends TaxOverrideManager
{
    public function replaceSutaUnemploymentTaxes(GeoPoint $suta_location, Collection &$taxable_incomes, Collection $wages, Collection $historical_wages): void
    {
    }

    public function addStateIncomeTax(GeoPoint $home_location, Collection $taxable_income, Collection $wages, Collection $historical_wages): void
    {
    }

    public function processReciprocalAgreements(Collection $reciprocal_agreements, Collection $taxable_incomes): void
    {
    }

    public function removeDisabledTaxes(Collection $disabled_taxes, Collection $taxable_incomes): void
    {
    }
}
