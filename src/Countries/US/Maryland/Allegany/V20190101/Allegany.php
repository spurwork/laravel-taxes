<?php

namespace Appleton\Taxes\Countries\US\Maryland\Allegany\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Maryland\Allegany\Allegany as BaseAllegany;
use Appleton\Taxes\Countries\US\Maryland\MarylandIncome\HasMarylandIncome;
use Appleton\Taxes\Models\Countries\US\Maryland\MarylandIncomeTaxInformation;
use Illuminate\Database\Eloquent\Collection;


class Allegany extends BaseAllegany
{
    use HasMarylandIncome;

    const SUPPLEMENTAL_TAX_RATE = 0.05;
    const TAX_RATE = 0.0305;

    const STANDARD_DEDUCTION = [
        'min' => 1500,
        'max' => 2250,
        'percentange' => 0.15,
    ];

    public function __construct(MarylandIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }

    public function getTaxBrackets()
    {
        return [[0, self::TAX_RATE, 0]];
    }
}