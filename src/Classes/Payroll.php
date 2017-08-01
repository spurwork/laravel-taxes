<?php

namespace Appleton\Taxes\Classes;

class Payroll
{
    public $date;
    public $earnings;
    public $pay_periods;
    public $supplemental_earnings;
    public $user;
    public $ytd_earnings;

    protected $tax_amount;

    public function __construct($parameters) {
        $this->date = $parameters['date'];
        $this->earnings = $parameters['earnings'];
        $this->pay_periods = $parameters['pay_periods'];
        $this->supplemental_earnings = $parameters['supplemental_earnings'];
        $this->user = $parameters['user'];
        $this->ytd_earnings = $parameters['ytd_earnings'];

        $this->amount_withheld = 0;
    }

    public function withholdTax($amount)
    {
        // var_dump([$amount, $this->getNetEarnings(), max(min($this->getNetEarnings(), $amount), 0)]);
        $amount = min($this->getNetEarnings(), $amount);
        $this->amount_withheld += $amount;
        return $amount;
    }

    public function getNetEarnings()
    {
        return $this->earnings - $this->amount_withheld;
    }
}
