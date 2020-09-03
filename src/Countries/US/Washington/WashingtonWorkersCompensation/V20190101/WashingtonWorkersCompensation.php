<?php

namespace Appleton\Taxes\Countries\US\Washington\WashingtonWorkersCompensation\V20190101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Classes\WorkerTaxes\Wage;
use Appleton\Taxes\Classes\WorkerTaxes\WageType;
use Appleton\Taxes\Countries\US\Washington\WashingtonWorkersCompensation\WashingtonWorkersCompensation as BaseWashingtonWorkersCompensation;
use Illuminate\Database\Eloquent\Collection;

class WashingtonWorkersCompensation extends BaseWashingtonWorkersCompensation
{
    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
    }

    public function compute(Collection $tax_areas)
    {
        $hourly = $this->payroll
            ->getWages($tax_areas->first()->workGovernmentalUnitArea, WageType::SHIFT)
            ->groupBy(function (Wage $wage) {
                return $wage->getPosition();
            })
            ->map(function ($wages) {
                $position = $wages->first()->getPosition();
                $rate = $this->payroll->getWorkerCompRate('WA', $position);
                $amount = $wages->sum(function (Wage $wage) {
                            return $wage->getWorkTimeInMinutes();
                }) / 60 * $rate->employee_rate / 100;
                $amount = $this->payroll->withholdTax($amount);
                $earnings = $wages->sum(function (Wage $wage) {
                        return $wage->getAmountInCents();
                }) / 100 - $this->payroll->exempted_earnings;

                return [
                    'rate_id' => $rate->id,
                    'position' => $position,
                    'amount' => $amount,
                    'earnings' => $earnings,
                ];
            });


        if ($this->payroll->getStartDate()->weekOfMonth < 5
            && $this->payroll->isSalariedWorker($tax_areas->first()->workGovernmentalUnitArea)) {
            $salary = $this->payroll
                ->getWages($tax_areas->first()->workGovernmentalUnitArea, WageType::SALARY)
                ->groupBy(function (Wage $wage) {
                    return $wage->getPosition();
                })
                ->map(function ($wages) {
                    $position = $wages->first()->getPosition();
                    $rate = $this->payroll->getWorkerCompRate('WA', $position);
                    $amount = ($wages->sum(function (Wage $wage) {
                        return $wage->getWorkTimeInMinutes();
                    }) / 60) * ($rate->employee_rate / 100);
                    $amount = $this->payroll->withholdTax($amount);
                    return [
                        'rate_id' => $rate->id,
                        'position' => $position,
                        'amount' => $amount,
                        'earnings' => ($wages->sum(function (Wage $wage) {
                                return $wage->getAmountInCents();
                            })) / 100 - $this->payroll->exempted_earnings,
                    ];
                });
        } else {
            $salary = collect([]);
        }

        // TODO: combine salary and hourly
        if ($hourly->isNotEmpty()) {
            return $hourly;
        }

        return $salary;
    }
}
