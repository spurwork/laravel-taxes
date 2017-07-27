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

    public function __construct($parameters) {
        $this->date = $parameters['date'];
        $this->earnings = $parameters['earnings'];
        $this->pay_periods = $parameters['pay_periods'];
        $this->supplemental_earnings = $parameters['supplemental_earnings'];
        $this->user = $parameters['user'];
        $this->ytd_earnings = $parameters['ytd_earnings'];
    }
}
