<?php

namespace Appleton\Taxes\Classes\WorkerTaxes;

use Appleton\Taxes\Models\GovernmentalUnitArea;
use Illuminate\Support\Collection;

class AreaIncome
{
    private $area;
    private $wages;
    private $annual_wages;

    public function __construct(
        GovernmentalUnitArea $area,
        Collection $wages,
        Collection $annual_wages)
    {
        $this->area = $area;
        $this->wages = $wages;
        $this->annual_wages = $annual_wages;
    }

    public function getArea(): GovernmentalUnitArea
    {
        return $this->area;
    }

    public function getWages(): Collection
    {
        return $this->wages;
    }

    public function getAnnualWages(): Collection
    {
        return $this->annual_wages;
    }
}
