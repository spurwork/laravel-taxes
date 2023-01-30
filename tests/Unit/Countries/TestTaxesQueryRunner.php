<?php

namespace Appleton\Taxes\Tests\Unit\Countries;

use Appleton\Taxes\Classes\WorkerTaxes\GeoPoint;
use Appleton\Taxes\Classes\WorkerTaxes\TaxesQueryRunner;
use Appleton\Taxes\Models\Tax;
use Illuminate\Support\Collection;
use InvalidArgumentException;

class TestTaxesQueryRunner extends TaxesQueryRunner
{
    private Collection $taxes;

    public function __construct()
    {
        $this->taxes = collect([]);
    }

    public function addTax(string $tax_class): void
    {
        $tax = Tax::query()->where('class', $tax_class)->first();
        if ($tax === null) {
            throw new InvalidArgumentException('Could not find tax: '.$tax_class);
        }

        $this->taxes->push($tax);
    }

    public function lookupTaxes(GeoPoint $home_location, GeoPoint $work_location): Collection
    {
        return $this->taxes;
    }
}
