<?php

namespace Appleton\Taxes\Classes;

use Appleton\Taxes\Models\TaxInformation;
use Appleton\Taxes\Traits\HasTaxBrackets;
use Exception;

abstract class BaseIncomeTax extends BaseTax
{
    use HasTaxBrackets;

    abstract public function getAdjustedEarnings();
    abstract public function getTaxBrackets();

    public function compute()
    {
        $adjusted_earnings = $this->getAdjustedEarnings();
        $tax_brackets = $this->getTaxBrackets();
        return round($this->getTaxAmountFromTaxBrackets($adjusted_earnings, $tax_brackets) / $this->pay_periods, 2);
    }

    public function resolveTaxInformation($information_type, $tax_information, $user)
    {
        if (!is_null($user) && is_null($tax_information)) {
            $tax_information = TaxInformation::forUser($this->user)->isTypeOf($information_type)->first();
        }

        if (is_null($tax_information)) {
            throw new Exception('Tax information could not be resolved.');
        }

        return $tax_information->information;
    }
}
