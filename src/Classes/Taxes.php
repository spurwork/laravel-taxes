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

        $this->bindPayrollData();
        $this->getTaxes();
        $this->bindInterfaces();

        $results = $this->compute();

        $this->unbindPayrollData();

        return $results;
    }

    private function bindInterfaces()
    {
        foreach ($this->taxes as $tax_name) {
            foreach (class_implements($tax_name) as $interface) {
                app()->bind($interface, $tax_name);
            }
        }
    }

    private function bindPayrollData()
    {
        app()->instance(Payroll::class, new Payroll([
            'date' => $this->getDate(),
            'earnings' => $this->earnings,
            'pay_periods' => $this->pay_periods,
            'supplemental_earnings' => $this->supplemental_earnings,
            'user' => $this->user,
            'ytd_earnings' => $this->ytd_earnings,
        ]));
    }

    private function compute()
    {
        $tax_results = [];

        foreach ($this->taxes as $tax_name) {
            $tax = app($tax_name);
            $tax_results[$tax_name] = [
                'tax' => $tax,
                'amount' => $tax->compute(),
            ];
        }

        return new TaxResults($tax_results);
    }

    private function getDate()
    {
        $test_now = env('TAXES_TEST_NOW');
        $date = is_null($test_now) ? $this->date : Carbon::parse($test_now);
        return  is_null($date) ? Carbon::now() : $date;
    }

    private function getTaxes()
    {
        $this->taxes = TaxArea::atPoint($this->latitude, $this->longitude)
            ->get()
            ->pluck('tax')
            ->toArray();
    }

    private function unbindPayrollData()
    {
        app()->forgetInstance(Payroll::class);
    }
}
