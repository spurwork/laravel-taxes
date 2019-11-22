<?php

namespace Appleton\Taxes\Classes\WorkerTaxes;

use Illuminate\Support\Collection;

class BindManager
{
    public function bindPayroll(Payroll $payroll): void
    {
        app()->instance(Payroll::class, $payroll);
    }

    public function bindTaxes(Collection $taxable_incomes): void
    {
        $tax_names = $taxable_incomes->map(static function (TaxableIncome $taxable_income) {
            return $taxable_income->getTax()->class;
        });

        foreach ($tax_names as $tax_name) {
            foreach (class_implements($tax_name) as $interface) {
                app()->bind($interface, $tax_name);
            }
        }
    }

    public function unbind(Collection $taxable_incomes): void
    {
        app()->forgetInstance(Payroll::class);

        $tax_names = $taxable_incomes->map(static function (TaxableIncome $taxable_income) {
            return $taxable_income->getTax()->class;
        });

        foreach ($tax_names as $tax_name) {
            foreach (class_implements($tax_name) as $interface) {
                app()->forgetInstance($interface);
            }

            app()->forgetInstance($tax_name);
        }
    }
}
