<?php

namespace Appleton\Taxes\Classes\WorkerTaxes;

use Appleton\Taxes\Models\GovernmentalUnitArea;
use Illuminate\Support\Collection;

class AreaIncome
{
    private $area;
    private $wages;
    private $historical_wages;

    public function __construct(
        GovernmentalUnitArea $area,
        Collection $wages,
        Collection $historical_wages)
    {
        $this->area = $area;
        $this->wages = $wages;
        $this->historical_wages = $historical_wages;
    }

    public function getArea(): GovernmentalUnitArea
    {
        return $this->area;
    }

    public function getWages(): Collection
    {
        return $this->wages;
    }

    public function getHistoricalWages(): Collection
    {
        return $this->historical_wages;
    }
}
