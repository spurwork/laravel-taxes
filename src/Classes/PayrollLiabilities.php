<?php

namespace Appleton\Taxes\Classes;

use Appleton\Taxes\Models\Tax;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Collection;

class PayrollLiabilities
{
    private $date;
    private $wages;
    private $ytd_wages;
    private $ytd_liabilities;
    private $work_location;

    public function setDate(Carbon $date): void
    {
        $this->date = $date;
    }

    public function setWorkLocation($location): void
    {
        $this->work_location = $location;
    }

    public function setWages(int $wages): void
    {
        $this->wages = $wages;
    }

    public function setYtdWages($ytd_earnings): void
    {
        $this->ytd_wages = $ytd_earnings;
    }

    public function setYtdLiabilities($ytd_earnings): void
    {
        $this->ytd_liabilities = $ytd_earnings;
    }

    private function getDate()
    {
        $test_now = env('TAXES_TEST_NOW');
        $date = $test_now === null ? $this->date : Carbon::parse($test_now);

        return $date ?? Carbon::now();
    }

    public function calculate(Closure $closure): PayrollLiabilityResults
    {
        $closure($this);

        $taxes = $this->getTaxes();
        $this->bindInterfaces($taxes);
        $this->bindPayrollData();

        $state_results = $this->computeState($taxes);

        $this->unbindPayrollData();
        $this->unbindTaxes($taxes);

        return new PayrollLiabilityResults($state_results);
    }

    private function computeState(Collection $taxes): Collection
    {
        $results = collect([]);
        $taxes->filter(static function ($tax) {
            return $tax->class::TYPE === 'state';
        })
            ->sortBy('class')
            ->sortBy(static function ($tax) {
                return $tax->class::PRIORITY;
            })
            ->each(static function ($tax) use (&$results) {
                $tax_implementation = app($tax->class);
                $amount = $tax_implementation->compute($tax->taxAreas);

                $liability = new PayrollLiability($tax->class, $amount, $tax_implementation->getWages());
                $results->put($tax->class, $liability);
                app()->instance($tax->class, $tax_implementation);
            });

        return $results;
    }

    private function getTaxes(): Collection
    {
        return Tax::atPoint($this->work_location, $this->work_location)
            ->with(['taxAreas' => function ($query) {
                $query->atPoint($this->work_location, $this->work_location);
            }])
            ->get()
            ->filter(static function (Tax $tax) {
                return $tax->class::SCOPE === 'payroll';
            });
    }

    private function bindPayrollData(): void
    {
        app()->instance(CompanyPayroll::class, new CompanyPayroll($this->getDate(),
            $this->wages, $this->ytd_wages, $this->ytd_liabilities));
    }

    private function bindInterfaces(Collection $taxes): void
    {
        foreach ($taxes->pluck('class') as $tax_name) {
            foreach (class_implements($tax_name) as $interface) {
                app()->bind($interface, $tax_name);
            }
        }
    }

    private function unbindPayrollData()
    {
        app()->forgetInstance(CompanyPayroll::class);
    }

    private function unbindTaxes(Collection $taxes)
    {
        $taxes->pluck('class')->each(static function ($tax_name) {
            app()->forgetInstance($tax_name);
        });
    }
}
