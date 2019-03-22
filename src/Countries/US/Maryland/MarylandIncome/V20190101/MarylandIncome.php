<?php

namespace Appleton\Taxes\Countries\US\Maryland\MarylandIncome\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Maryland\MarylandIncome\MarylandIncome as BaseMarylandIncome;
use Appleton\Taxes\Models\Countries\US\Maryland\MarylandIncomeTaxInformation;

class MarylandIncome extends BaseMarylandIncome
{
    const SUPPLEMENTAL_TAX_RATE = 0.05;

    private const TAX_RATE = 0.05;

    public function __construct(MarylandIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($tax_information, $payroll);
    }

    public function getTaxBrackets()
    {
        return [[0, self::TAX_RATE, 0]];
    }
}