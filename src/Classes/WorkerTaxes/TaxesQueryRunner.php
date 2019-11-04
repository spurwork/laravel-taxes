<?php

namespace Appleton\Taxes\Classes\WorkerTaxes;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateIncome;
use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateUnemployment;
use Appleton\Taxes\Models\GovernmentalUnitArea;
use Appleton\Taxes\Models\Tax;
use Appleton\Taxes\Models\TaxArea;
use Exception;
use Illuminate\Support\Collection;

class TaxesQueryRunner
{
    public function lookupTaxes(
        GeoPoint $home_location,
        GeoPoint $work_location): Collection
    {
        $home_location_array = $home_location->toArray();
        $work_location_array = $work_location->toArray();

        return Tax::atPoint($home_location_array, $work_location_array)
            ->with(['taxAreas' => static function ($query) use ($home_location_array, $work_location_array) {
                $query->atPoint($home_location_array, $work_location_array);
            }])
            ->get()
            ->filter(static function (Tax $tax) {
                return $tax->class::SCOPE === TaxScope::WORKER;
            });
    }

    public function lookupTax(string $tax_class): Tax
    {
        $tax = Tax::query()
            ->where('class', $tax_class)
            ->first();

        if ($tax === null) {
            throw new Exception('Could not find tax '.$tax_class);
        }

        return $tax;
    }

    public function lookupStateIncomeTaxByLocation(GeoPoint $location): ?Tax
    {
        $location_array = $location->toArray();

        return Tax::atPoint($location_array, $location_array)
            ->get()
            ->first(static function ($tax) {
                return is_subclass_of($tax->class, BaseStateIncome::class);
            });
    }

    public function lookupStateIncomeTaxByName(string $name): ?Tax
    {
        $governmental_unit_area = GovernmentalUnitArea::query()
            ->with(['workTaxAreas', 'workTaxAreas.tax'])
            ->where('name', $name)
            ->get()
            ->first(static function (GovernmentalUnitArea $governmental_unit_area) {
                return $governmental_unit_area->workTaxAreas->first(function (TaxArea $tax_area) {
                    return is_subclass_of($tax_area->tax->class, BaseStateIncome::class);
                });
            });

        if($governmental_unit_area === null) {
            return null;
        }

        return $governmental_unit_area->workTaxAreas->first()->tax;
    }

    public function lookupStateUnemploymentTaxes(GeoPoint $location): Collection
    {
        $location_array = $location->toArray();

        return Tax::atPoint($location_array, $location_array)
            ->get()
            ->filter(static function (Tax $tax) {
                return is_subclass_of($tax->class, BaseStateUnemployment::class);
            });
    }

    public function lookupGovernmentalAreas(GeoPoint $location): Collection
    {
        return GovernmentalUnitArea::atPoint($location->getLatitude(), $location->getLongitude())->get();
    }
}
