<?php

namespace Appleton\Taxes\Classes;

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

    public function getLiability(string $tax)
    {
        $liabilities = $this->results->filter(static function (PayrollLiability $liability) use ($tax) {
            return $liability->getTaxClass() === $tax;
        });
        return $this->transform($liabilities)->first();
    }

    public function getStateLiabilities(): Collection
    {
        $liabilities = $this->results->filter(static function (PayrollLiability $liability) {
            return $liability->getTaxClass()::TYPE === 'state';
        });
        return $this->transform($liabilities);
    }

    private function transform(Collection $results)
    {
        return $results->map(static function (PayrollLiability $result) {
            return $result->getAmount();
        });
    }
}
