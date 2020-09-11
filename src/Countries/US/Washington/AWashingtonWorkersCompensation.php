<?php

namespace Appleton\Taxes\Countries\US\Washington;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseTax;
use Appleton\Taxes\Classes\WorkerTaxes\Wage;
use Appleton\Taxes\Classes\WorkerTaxes\WageType;
use Illuminate\Database\Eloquent\Collection;

abstract class AWashingtonWorkersCompensation extends BaseTax
{
    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
    }

    abstract protected function getTaxRate($rate): float;

    public function compute(Collection $tax_areas)
    {
        $results = $this->convertWages($tax_areas, WageType::SHIFT);

        if ($this->payroll->getStartDate()->weekOfMonth < 5
            && $this->payroll->isSalariedWorker($tax_areas->first()->workGovernmentalUnitArea)) {
            $this->convertWages($tax_areas, WageType::SALARY)
                ->each(function ($result, $key) use ($results) {
                    if ($results->has($key)) {
                        $results->put($key, [
                            'rate_id' => $result['rate_id'],
                            'amount' => $results[$key]['amount'] + $result['amount'],
                            'earnings' => $results[$key]['earnings'] + $result['earnings'],
                        ]);
                    } else {
                        $results->put($key, $result);
                    }
                });
        }

        return $results;
    }

    private function convertWages(
        \Illuminate\Support\Collection $tax_areas,
        string $wage_type
    ): \Illuminate\Support\Collection {
        return $this->payroll->getWages($tax_areas->first()->workGovernmentalUnitArea, $wage_type)
            ->groupBy(function (Wage $wage) {
                return $wage->getPosition();
            })
            ->mapWithKeys(function ($wages) {
                $position = $wages->first()->getPosition();
                $rate = $this->payroll->getWorkerCompRate('WA', $position);

                $minutes_worked = $wages->sum(function (Wage $wage) {
                    return $wage->getWorkTimeInMinutes();
                });

                $amount = ($minutes_worked / 60) * ($this->getTaxRate($rate) / 100);

                $earnings = $wages->sum(function (Wage $wage) {
                    return $wage->getAmountInCents();
                });

                return [
                    $rate->id => [
                        'rate_id' => $rate->id,
                        'amount' => $this->payroll->withholdTax($amount),
                        'earnings' => ($earnings / 100) - $this->payroll->exempted_earnings,
                    ]
                ];
            });
    }
}