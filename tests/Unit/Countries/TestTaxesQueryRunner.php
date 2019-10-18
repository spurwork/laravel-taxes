<?php

namespace Appleton\Taxes\Tests\Unit\Countries;

use Appleton\Taxes\Classes\WorkerTaxes\GeoPoint;
use Appleton\Taxes\Classes\WorkerTaxes\TaxesQueryRunner;
use Appleton\Taxes\Models\Tax;
use Exception;
use Illuminate\Support\Collection;

class TestTaxesQueryRunner extends TaxesQueryRunner
{
    private $taxes;

    public function __construct()
    {
        $this->taxes = collect([]);
    }

    public function addTax(string $tax_class): void
    {
        $tax = Tax::where('class', $tax_class)->first();
        if ($tax === null) {
            throw new Exception('Could not find tax: '.$tax_class);
        }

        $this->taxes->push($tax);
    }

    public function lookupTaxes(GeoPoint $home_location, GeoPoint $work_location): Collection
    {
        return $this->taxes;
    }
}
