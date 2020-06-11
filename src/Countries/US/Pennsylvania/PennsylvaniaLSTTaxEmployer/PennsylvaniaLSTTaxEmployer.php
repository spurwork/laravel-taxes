<?php

namespace Appleton\Taxes\Countries\US\Pennsylvania\PennsylvaniaLSTTaxEmployer;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseLocal;
use Appleton\Taxes\Models\Countries\US\Pennsylvania\PennsylvaniaIncomeTaxInformation;

abstract class PennsylvaniaLSTTaxEmployer extends BaseLocal
{
    const WITHHELD = false;

    public function __construct(PennsylvaniaIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }
}
