<?php

namespace Appleton\Taxes\Classes\WorkerTaxes;

use Illuminate\Support\Collection;

class BindManager
{
    public function bind(Payroll $payroll, Collection $taxable_incomes): void
    {
        app()->instance(Payroll::class, $payroll);

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
