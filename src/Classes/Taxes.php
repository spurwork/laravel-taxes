<?php

namespace Appleton\Taxes\Classes;

use Appleton\Taxes\Models\TaxArea;
use Appleton\Taxes\Models\TaxInformation;
use Closure;

class Taxes
{
    protected $ytd_earnings = 0;

    public function setEarnings($earnings)
    {
        $this->earnings = $earnings;
    }

    public function setYtdEarnings($ytd_earnings)
    {
        $this->ytd_earnings = $ytd_earnings;
    }

    public function setPayPeriods($pay_periods)
    {
        $this->pay_periods = $pay_periods;
    }

    public function setWorkLocation($latitude, $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function calculate(Closure $closure)
    {
        $closure($this);

        $this->taxes = TaxArea::atPoint($this->latitude, $this->longitude)
            ->get()
            ->pluck('tax')
            ->toArray();

        $this->taxes = app()->make(TaxResolver::class)->resolve($this->taxes);

        $tax_results = [];
        foreach ($this->taxes as $tax_name) {
            $tax_results[$tax_name] = app()->makeWith($tax_name, [
                'earnings' => $this->earnings,
                'ytd_earnings' => $this->ytd_earnings,
                'pay_periods' => $this->pay_periods,
                'user' => $this->user,
            ])->compute();
        }

        $tax_results = app()->makeWith(TaxResults::class, [
            'tax_results' => $tax_results
        ]);

        return $tax_results;
    }

    public static function resolve($name, $date = null)
    {
        return app()->make(TaxResolver::class)->resolve($name, $date, false)[0];
    }
}
