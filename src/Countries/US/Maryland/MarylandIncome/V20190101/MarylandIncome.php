<?php

namespace Appleton\Taxes\Countries\US\Maryland\MarylandIncome\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Maryland\MarylandIncome\HasMarylandIncome;
use Appleton\Taxes\Countries\US\Maryland\MarylandIncome\MarylandIncome as BaseMarylandIncome;
use Appleton\Taxes\Models\Countries\US\Maryland\MarylandIncomeTaxInformation;

class MarylandIncome extends BaseMarylandIncome
{
    use HasMarylandIncome;

    const SUPPLEMENTAL_TAX_RATE = 0.05;

    private const TAX_RATE = 0.05;
    private $worked_in_delaware = false;

    const SINGLE_BRACKETS_DELAWARE = [
        [0, 0.065, 0],
        [100000, 0.0675, 6500.00],
        [125000, 0.07, 8187.50],
        [150000, 0.0725, 9937.50],
        [250000, 0.75, 17187.50]
    ];

    const MARRIED_BRACKETS_DELAWARE = [
        [0, 0.065, 0],
        [15000, 0.0675, 9750.00],
        [175000, 0.07, 11437.50],
        [225000, 0.0725, 14937.50],
        [300000, 0.75, 20375.00],
    ];

    const SINGLE_BRACKETS = [
        [0, 0.0475, 0],
        [100000, 0.05, 4750.00],
        [125000, 0.0525, 6000.00],
        [150000, 0.055, 7312.50],
        [250000, 0.0575, 12812.50],
    ];

    const MARRIED_BRACKETS = [
        [0, 0.0475, 0],
        [150000, 0.05, 7125.00],
        [175000, 0.0525, 8375.00],
        [225000, 0.0525, 11000.00],
        [300000, 0.575, 15125.00],
    ];

    const STANDARD_DEDUCTION = [
        'min' => 1500,
        'max' => 2250,
        'percentange' => 0.15,
    ];

    public function __construct(MarylandIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($tax_information, $payroll);
    }

    public function getTaxBrackets()
    {
        if ($this->worked_in_delaware) {
            if ($this->tax_information->filing_status === static::FILING_MARRIED_HEAD_OF_HOUSEHOLD) {
                return static::MARRIED_BRACKETS_DELAWARE;
            }
            return static::SINGLE_BRACKETS_DELAWARE;
        }

        // change if worked in delaware
        if ($this->tax_information->filing_status === static::FILING_MARRIED_HEAD_OF_HOUSEHOLD) {
            return static::MARRIED_BRACKETS;
        }
        return static::SINGLE_BRACKETS;
    }
}