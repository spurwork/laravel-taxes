<?php

namespace Appleton\Taxes\Countries\US\NewMexico\NewMexicoIncome\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\NewMexico\NewMexicoIncome\NewMexicoIncome as BaseNewMexicoIncome;
use Appleton\Taxes\Models\Countries\US\NewMexico\NewMexicoIncomeTaxInformation;

class NewMexicoIncome extends BaseNewMexicoIncome
{
    const SUPPLEMENTAL_TAX_RATE = 0.049;

    const SINGLE_BRACKETS = [
        [0, 0.00, 0],
        [3700, 0.017, 0],
        [9200, 0.032, 93.5],
        [14700, 0.047, 269.5],
        [19700, 0.049, 504.5],
        [29700, 0.049, 994.5],
        [45700, 0.049, 1778.5],
        [68700, 0.049, 2905.5],
    ];

    const MARRIED_BRACKETS = [
        [0, 0.00, 0],
        [11500, 0.017, 0],
        [19550, 0.032, 136],
        [27550, 0.047, 392],
        [35550, 0.049, 768],
        [51550, 0.049, 1552],
        [75550, 0.049, 2728],
        [111550, 0.049, 4492],
    ];

    const EXEMPTION_ALLOWANCE_AMOUNT = 4150;

    public function __construct(NewMexicoIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($tax_information, $payroll);
        $this->tax_information = $tax_information;
    }

    public function compute()
    {
        if ($this->isUserClaimingExemption())
        {
            return 0.00;
        }

        $this->tax_total = $this->payroll->withholdTax($this->getTaxAmountFromTaxBrackets($this->getAdjustedEarnings(), $this->getTaxBrackets()) / $this->payroll->pay_periods) +
            $this->payroll->withholdTax($this->getSupplementalIncomeTax()) +
            $this->payroll->withholdTax($this->getAdditionalWithholding());

        return round(intval($this->tax_total * 1000) / 1000, 2);

    }


    public function getAdjustedEarnings()
    {
        return $this->getGrossEarnings() - $this->getAllowanceExemption();
    }

    public function getTaxBrackets()
    {
        if ($this->tax_information->filing_status === static::FILING_SINGLE || $this->tax_information->filing_status === static::FILING_HEAD_OF_HOUSEHOLD) {
            return static::SINGLE_BRACKETS;
        } else {
            return static::MARRIED_BRACKETS;
        }
    }

    private function getAllowanceExemption()
    {
        return $this->tax_information->exemptions * self::EXEMPTION_ALLOWANCE_AMOUNT;
    }

    private function getGrossEarnings()
    {
        return ($this->payroll->earnings - $this->payroll->supplemental_earnings) * $this->payroll->pay_periods;
    }
}
