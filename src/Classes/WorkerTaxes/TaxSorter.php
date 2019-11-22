<?php

namespace Appleton\Taxes\Classes\WorkerTaxes;

use Illuminate\Support\Collection;

class TaxSorter
{
    private const TAX_TYPE_ORDER = [TaxType::FEDERAL, TaxType::STATE, TaxType::LOCAL];

    /**
     * Sort taxes based on type, then order, then name
     */
    public function sort(Collection $taxable_incomes): Collection
    {
        return $taxable_incomes->sort(static function (TaxableIncome $taxable_income_1, TaxableIncome $taxable_income_2) {
            $type_order_1 = array_search($taxable_income_1->getTax()->class::TYPE, self::TAX_TYPE_ORDER, true);
            $type_order_2 = array_search($taxable_income_2->getTax()->class::TYPE, self::TAX_TYPE_ORDER, true);

            $type_compare = $type_order_1 <=> $type_order_2;

            if ($type_compare !== 0) {
                return $type_compare;
            }

            $priority_compare = $taxable_income_1->getTax()->class::PRIORITY <=> $taxable_income_2->getTax()->class::PRIORITY;
            if ($priority_compare !== 0) {
                return $priority_compare;
            }

            return $taxable_income_1->getTax()->name <=> $taxable_income_2->getTax()->name;
        });
    }
}
