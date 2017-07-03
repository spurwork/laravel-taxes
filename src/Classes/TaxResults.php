<?php

namespace Appleton\Taxes\Classes;

class TaxResults
{
    public function __construct($tax_results)
    {
        $this->tax_results = collect($tax_results);        
    }

    public function getTax($tax)
    {
        return $this->tax_results->filter(function ($tax_result, $tax_name) use ($tax) {
            return $tax_name === $tax;
        })->first();
    }

    public function getAllTaxes()
    {
        return $this->tax_results;
    }

    public function getStateAndLocalTaxes()
    {
        return $this->tax_results->filter(function ($tax_result, $tax_name) {
            return in_array($tax_name::getType(), ['state', 'local']);
        });
    }

    public function getFederalTaxes()
    {
        return $this->tax_results->filter(function ($tax_result, $tax_name) {
            return $tax_name->getType() === 'federal';
        });
    }

    // public function getEmployerMedicare()
    // {
    //     return $this->tax_results->filter(function ($tax_result) {
    //         return $tax_result->getType() === 'federal';
    //     });

    //     return $this->tax_results->where('withheld', false)->filter(function ($value, $key) {
    //         return $key == 'Medicare Employer Tax';
    //     });
    // }

    // public function getFederalIncome()
    // {
    //     return $this->tax_results->where('withheld', true)->filter(function ($value, $key) {
    //         return (str_contains($key, 'FIT'));
    //     });
    // }

    // public function getEmployerSocialSecurity()
    // {
    //     return $this->tax_results->where('withheld', false)->filter(function ($value, $key) {
    //         return $key == 'Social Security Employer Tax';
    //     });
    // }

    // public function getFuta()
    // {
    //     return $this->tax_results->where('withheld', false)->filter(function ($value, $key) {
    //         return $key == 'Federal Unemployment Tax';
    //     });
    // }

    // public function getSuta()
    // {
    //     return $this->tax_results->filter(function ($value, $key) {
    //         return $key == 'Alabama Unemployment Tax';
    //     });
    // }

    // public function getEmployerTaxes()
    // {
    //     return $this->tax_results->where('withheld', false);
    // }

    // public function getEmployeeTaxes()
    // {
    //     return $this->tax_results->where('withheld', true);
    // }
}
