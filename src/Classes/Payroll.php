<?php

namespace Appleton\Taxes\Classes;

class Payroll
{
    public $date;
    public $earnings;
    public $exemptions;
    public $pay_periods;
    public $supplemental_earnings;
    public $user;
    public $wtd_earnings;
    public $ytd_earnings;

    protected $amount_withheld;

    public function __construct($parameters) {
        $this->date = $parameters['date'];
        $this->earnings = $parameters['earnings'] ?? 0;
        $this->exemptions = collect($parameters['exemptions'] ?? []);
        $this->pay_periods = $parameters['pay_periods'] ?? 52;
        $this->supplemental_earnings = $parameters['supplemental_earnings'] ?? 0;
        $this->user = $parameters['user'];
        $this->wtd_earnings = $parameters['wtd_earnings'] ?? 0;
        $this->ytd_earnings = $parameters['ytd_earnings'] ?? 0;

        $this->amount_withheld = 0;
    }

    public function exemptEarnings($class_name)
    {
        $max_amount_exempt = $this->exemptions->get($class_name, 0);
        $this->exempted_earnings = min($max_amount_exempt, $this->earnings);
        $this->exempted_supplemental_earnings = min($max_amount_exempt - $this->exempted_earnings, $this->supplemental_earnings);
        return $this;
    }

    public function withholdTax($amount)
    {
        $amount = min($this->getNetEarnings(), $amount);
        $this->amount_withheld += $amount;
        return $amount;
    }

    public function getNetEarnings()
    {
        return $this->getEarnings() - $this->amount_withheld;
    }

    public function getEarnings()
    {
        return $this->earnings - $this->exempted_earnings;
    }

    public function getSupplementalEarnings()
    {
        return $this->supplemental_earnings - $this->exempted_supplemental_earnings;
    }
}
