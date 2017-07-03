<?php

namespace Appleton\Taxes\Classes;

class TaxResults
{
    public function __construct($tax_results, $date)
    {
        $this->tax_results = collect($tax_results);        
    }

    public function getAllTaxes()
    {
        return $this->tax_results;
    }

    public function getEmployeeTaxes()
    {
        return $this->tax_results->filter(function ($tax_result, $tax_name) {
            return Taxes::resolve($tax_name)::WITHHELD;
        });
    }

    public function getEmployerTaxes()
    {
        return $this->tax_results->filter(function ($tax_result, $tax_name) {
            return !Taxes::resolve($tax_name)::WITHHELD;
        });
    }

    public function getFederalTaxes()
    {
        return $this->tax_results->filter(function ($tax_result, $tax_name) {
            return Taxes::resolve($tax_name)::TYPE === 'federal';
        });
    }

    public function getStateAndLocalTaxes()
    {
        return $this->tax_results->filter(function ($tax_result, $tax_name) {
            return in_array(Taxes::resolve($tax_name)::TYPE, ['state', 'local']);
        });
    }

    public function getTax($tax)
    {
        return $this->tax_results->filter(function ($tax_result, $tax_name) use ($tax) {
            return $tax_name === $tax;
        })->first();
    }
}
