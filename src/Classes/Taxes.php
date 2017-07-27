<?php

namespace Appleton\Taxes\Classes;

use Appleton\Taxes\Models\TaxArea;
use Appleton\Taxes\Models\TaxInformation;
use Carbon\Carbon;
use Closure;

class Taxes
{
    protected $date = null;
    protected $pay_periods = 1;
    protected $supplemental_earnings = 0;
    protected $ytd_earnings = 0;

    public function getDate()
    {
        $test_now = env('TAXES_TEST_NOW');
        return is_null($test_now) ? $this->date : Carbon::parse($test_now);
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function setEarnings($earnings)
    {
        $this->earnings = $earnings;
    }

    public function setPayPeriods($pay_periods)
    {
        $this->pay_periods = $pay_periods;
    }

    public function setSupplementalEarnings($supplemental_earnings)
    {
        $this->supplemental_earnings = $supplemental_earnings;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function setWorkLocation($location)
    {
        $this->latitude = $location[0];
        $this->longitude = $location[1];
    }

    public function setYtdEarnings($ytd_earnings)
    {
        $this->ytd_earnings = $ytd_earnings;
    }

    public function calculate(Closure $closure)
    {
        $closure($this);

        app()->instance(Payroll::class, new Payroll([
            'date' => $this->getDate(),
            'earnings' => $this->earnings,
            'pay_periods' => $this->pay_periods,
            'supplemental_earnings' => $this->supplemental_earnings,
            'user' => $this->user,
            'ytd_earnings' => $this->ytd_earnings,
        ]));

        $this->taxes = TaxArea::atPoint($this->latitude, $this->longitude)
            ->get()
            ->pluck('tax')
            ->toArray();

        $tax_results = [];

        foreach ($this->taxes as $tax_name) {
            $tax_results[$tax_name] = app($tax_name)->compute();
        }

        return new TaxResults($tax_results);
    }
}
