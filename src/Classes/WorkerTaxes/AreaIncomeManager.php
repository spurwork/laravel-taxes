<?php

namespace Appleton\Taxes\Classes\WorkerTaxes;

use Appleton\Taxes\Models\GovernmentalUnitArea;
use Illuminate\Support\Collection;

class AreaIncomeManager
{
    private $query_runner;

    public function __construct(TaxesQueryRunner $query_runner)
    {
        $this->query_runner = $query_runner;
    }

    public function groupWagesByGovernmentalArea(
        Collection $wages_by_lat_long,
        Collection $annual_wages_by_lat_long): Collection
    {
        $area_incomes = collect([]);

        $wages_by_lat_long->each(function (Collection $wages) use ($area_incomes) {
            if ($wages->isEmpty()) {
                return;
            }

            $location = $wages->first()->getLocation();
            $governmental_areas = $this->query_runner->lookupGovernmentalAreas($location);
            $governmental_areas->each(function (GovernmentalUnitArea $area) use ($area_incomes, $wages) {
                $this->addWages($area_incomes, $area, $wages, collect([]));
            });
        });

        $annual_wages_by_lat_long->each(function (Collection $annual_wages) use ($area_incomes) {
            if ($annual_wages->isEmpty()) {
                return;
            }

            $location = $annual_wages->first()->getLocation();
            $governmental_areas = $this->query_runner->lookupGovernmentalAreas($location);
            $governmental_areas->each(function (GovernmentalUnitArea $area) use ($area_incomes, $annual_wages) {
                $this->addWages($area_incomes, $area, collect([]), $annual_wages);
            });
        });

        return $area_incomes;
    }

    private function addWages(
        Collection $area_incomes,
        GovernmentalUnitArea $governmental_unit_area,
        Collection $wages,
        Collection $annual_wages): void
    {
        if (!$area_incomes->has($governmental_unit_area->name)) {
            $empty_area_income = new AreaIncome($governmental_unit_area, collect([]), collect([]));
            $area_incomes->put($governmental_unit_area->name, $empty_area_income);
        }

        /** @var AreaIncome $area_income */
        $area_income = $area_incomes->get($governmental_unit_area->name);

        $new_area_income = new AreaIncome(
            $area_income->getArea(),
            $area_income->getWages()->concat($wages),
            $area_income->getAnnualWages()->concat($annual_wages));

        $area_incomes->put($governmental_unit_area->name, $new_area_income);
    }

    public function getHomeAreas(GeoPoint $home_location): Collection
    {
        return $this->query_runner->lookupGovernmentalAreas($home_location)
            ->mapWithKeys(static function (GovernmentalUnitArea $area) {
                return [$area->name => $area];
            });
    }
}
