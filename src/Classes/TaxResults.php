<?php

namespace Appleton\Taxes\Classes;

class TaxResults
{
    public function __construct($results)
    {
        $this->results = collect($results);
    }

    private function transform($results, $field = 'amount')
    {
        return $results->map(function($result) use ($field) {
            return $result[$field];
        });
    }

    public function getAllTaxes()
    {
        return $this->transform($this->results);
    }

    public function getEmployeeTaxes()
    {
        $results = $this->results->filter(function ($result) {
            return $result['tax']::WITHHELD;
        });

        return $this->transform($results);
    }

    public function getEmployerTaxes()
    {
        $results = $this->results->filter(function ($result) {
            return !$result['tax']::WITHHELD;
        });

        return $this->transform($results);
    }

    public function getFederalTaxes()
    {
        $results = $this->results->filter(function ($result) {
            return $result['tax']::TYPE === 'federal';
        });

        return $this->transform($results);
    }

    public function getStateAndLocalTaxes()
    {
        $results = $this->results->filter(function ($result) {
            return in_array($result['tax']::TYPE, ['state', 'local']);
        });

        return $this->transform($results);
    }

    public function getTax($tax)
    {
        return $this->transform($this->results->filter(function ($result, $tax_name) use ($tax) {
            return $tax_name === $tax;
        }))->first();
    }

    public function getAdjustedEarnings($tax)
    {
        return $this->transform($this->results->filter(function ($result, $tax_name) use ($tax) {
            return $tax_name === $tax;
        }), 'adjusted_earnings')->first();
    }
}
