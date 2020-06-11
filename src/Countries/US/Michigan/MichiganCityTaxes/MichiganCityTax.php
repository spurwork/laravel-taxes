<?php

namespace Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseLocal;
use Appleton\Taxes\Models\Countries\US\Michigan\MichiganIncomeTaxInformation;
use Illuminate\Database\Eloquent\Collection;

abstract class MichiganCityTax extends BaseLocal
{
    protected $tax_information;
    protected $payroll;

    public function __construct(MichiganIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }

    // use the doesApply method but check against the name



    // abstract protected function getId(): string;

    // abstract protected function getTaxRate(): float;

    // public function doesApply(Collection $tax_areas): bool
    // {
    //     return $this->tax_information->school_district_id === $this->getId();
    // }

    // public function compute(Collection $tax_areas)
    // {
    //     if ($this->tax_information->exempt) {
    //         return 0.0;
    //     }

    //     return round($this->payroll->getEarnings() * $this->getTaxRate(), 2);
    // }
}
