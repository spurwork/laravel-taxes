<?php

namespace Appleton\Taxes\Classes;

use Appleton\Taxes\Models\TaxArea;
use Appleton\Taxes\Models\TaxInformation;
use Closure;

class Taxes
{
    public function getCredit()
    {
        foreach ($this->taxes as $tax_name) {
            $class_name = $tax_name::getClassName();
            if (is_subclass_of($class_name, BaseStateUnemploymentTax::class)) {
                return $class_name::getUnemploymentTaxCredit();
            }
        }
    }

    public function setEarnings($earnings)
    {
        $this->earnings = $earnings;
    }

    public function setPayPeriods($pay_periods)
    {
        $this->pay_periods = $pay_periods;
    }

    public function setLocation($latitude, $longitude)
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

        $this->credit = $this->getCredit();

        $tax_results = [];
        foreach ($this->taxes as $tax_name) {
            $tax_results[$tax_name] = app()->makeWith($tax_name, [
                'earnings' => $this->earnings,
                'credit' => $this->credit,
                'pay_periods' => $this->pay_periods,
                'user' => $this->user,
            ])->compute();
        }

        $tax_results = app()->makeWith(TaxResults::class, [
            'tax_results' => $tax_results
        ]);

        return $tax_results;
    }
}
