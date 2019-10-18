<?php

namespace Appleton\Taxes\Classes\PayrollLiabilities;

use Illuminate\Support\Collection;

class PayrollLiabilityResults
{
    private $results;

    public function __construct(Collection $results)
    {
        $this->results = $results->reject(static function (PayrollLiability $liability) {
            return $liability->getAmount() <= 0;
        });
    }

    public function getLiability(string $tax): ?float
    {
        $liabilities = $this->results->filter(static function (PayrollLiability $liability) use ($tax) {
            return $liability->getTaxClass() === $tax;
        });
        return $this->transformAmount($liabilities)->first();
    }

    public function getLiabilities(): Collection
    {
        return $this->transformAmount($this->results);
    }

    public function getWages(string $tax): ?int
    {
        return $this->results->filter(static function ($result, $tax_name) use ($tax) {
            return $tax_name === $tax;
        })->map(static function (PayrollLiability $liability) {
            return $liability->getWages();
        })->first();
    }

    private function transformAmount(Collection $results)
    {
        return $results->map(static function (PayrollLiability $liability) {
            return $liability->getAmount();
        });
    }
}
