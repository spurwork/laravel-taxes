<?php

namespace Appleton\Taxes\Countries\US\Medicare\V20170101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Medicare\Medicare as BaseMedicare;
use Appleton\Taxes\Models\Countries\US\FederalIncomeTaxInformation;

class Medicare extends BaseMedicare
{
    const TAX_RATE = 0.0145;

    const ADDITIONAL_TAX_AMOUNT = [
        self::FILING_SINGLE => 200000,
        self::FILING_WIDOW => 200000,
        self::FILING_HEAD_OF_HOUSEHOLD => 200000,
        self::FILING_MARRIED => 250000,
        self::FILING_SEPERATE => 125000,
    ];

    const ADDITIONAL_TAX_RATE = 0.009;

    public function __construct(FederalIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }

    public function getAdditionalTaxAmount()
    {
        return max($this->payroll->getEarnings() - max(static::ADDITIONAL_TAX_AMOUNT[$this->tax_information->filing_status] - $this->payroll->ytd_earnings, 0), 0) * static::ADDITIONAL_TAX_RATE;
    }

    public function compute()
    {
        $this->tax_total = $this->payroll->withholdTax($this->payroll->getEarnings() * static::TAX_RATE + $this->getAdditionalTaxAmount());
        return round($this->tax_total, 2);
    }
}
