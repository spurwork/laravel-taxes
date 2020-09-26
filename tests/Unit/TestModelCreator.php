<?php

namespace Appleton\Taxes\Tests\Unit;

use Appleton\Taxes\Classes\WorkerTaxes\GeoPoint;
use Appleton\Taxes\Classes\WorkerTaxes\LiabilityAmount;
use Appleton\Taxes\Classes\WorkerTaxes\TaxableWage;
use Appleton\Taxes\Classes\WorkerTaxes\Wage;
use Appleton\Taxes\Classes\WorkerTaxes\WageType;
use Appleton\Taxes\Classes\WorkerTaxes\WorkerCompRate;
use Appleton\Taxes\Models\TaxArea;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait TestModelCreator
{
    protected function makeAreaAtPoint(GeoPoint $location): int
    {
        $latitude = $location->getLatitude();
        $longitude = $location->getLongitude();

        return DB::table('governmental_unit_areas')->insertGetId([
            'name' => "point (${latitude}, ${longitude})",
            'area' => DB::raw("ST_SetSRID(ST_MakePoint(${latitude}, ${longitude}),4326)"),
        ]);
    }

    protected function makeAreaAtCircle(float $latitude, float $longitude): int
    {
        return DB::table('governmental_unit_areas')->insertGetId([
            'name' => "circle (${latitude}, ${longitude}) 10km radius",
            'area' => DB::raw("ST_Buffer(ST_SetSRID(ST_MakePoint(${latitude}, ${longitude}),4326), 10)"),
        ]);
    }

    protected function makeTax(string $class): int
    {
        return DB::table('taxes')->insertGetId([
            'name' => 'Tax '.$class,
            'class' => $class,
        ]);
    }

    protected function makeTaxArea(string $class, int $govt_id): void
    {
        $tax_id = $this->makeTax($class);

        DB::table('tax_areas')->insertGetId([
            'based' => TaxArea::BASED_ON_WORK_LOCATION,
            'tax_id' => $tax_id,
            'work_governmental_unit_area_id' => $govt_id,
        ]);
    }

    protected function makeWage(
        GeoPoint $location,
        int $amount_in_cents = UnitTestCase::DEFAULT_SHIFT_WAGES,
        int $pay_check_tip_amount_in_cents = null,
        int $take_home_tip_amount_in_cents = null,
        ?int $minutes_worked = UnitTestCase::DEFAULT_MINUTES_WORKED,
        ?int $position = UnitTestCase::DEFAULT_POSITION
    ): Wage {
        return new Wage(
            WageType::SHIFT,
            Carbon::now(),
            $location,
            $amount_in_cents,
            $pay_check_tip_amount_in_cents === null ? 0 : $pay_check_tip_amount_in_cents,
            $take_home_tip_amount_in_cents === null ? 0 : $take_home_tip_amount_in_cents,
            $minutes_worked === null ? UnitTestCase::DEFAULT_MINUTES_WORKED : $minutes_worked,
            collect([]),
            $position
        );
    }

    protected function makeTaxableWage(
        string $tax_class,
        int $amount
    ): TaxableWage {
        return new TaxableWage(
            $amount,
            Carbon::now(),
            $tax_class
        );
    }

    protected function makeTaxableWageAtDate(
        Carbon $date,
        string $tax_class,
        int $amount
    ): TaxableWage {
        return new TaxableWage(
            $amount,
            $date,
            $tax_class
        );
    }

    protected function makeLiabilityAmount(
        string $tax_class,
        int $amount
    ): LiabilityAmount {
        return new LiabilityAmount(
            $amount,
            Carbon::now(),
            $tax_class
        );
    }

    protected function makeLiabilityAmountAtDate(
        Carbon $date,
        string $tax_class,
        int $amount
    ): LiabilityAmount {
        return new LiabilityAmount(
            $amount,
            $date,
            $tax_class
        );
    }

    protected function makeWageWithAdditionalTax(
        GeoPoint $location,
        string $additional_tax,
        int $amount_in_cents = UnitTestCase::DEFAULT_SHIFT_WAGES,
        ?int $position = UnitTestCase::DEFAULT_POSITION
    ): Wage {
        return new Wage(
            WageType::SHIFT,
            Carbon::now(),
            $location,
            $amount_in_cents,
            0,
            0,
            0,
            collect([$additional_tax]),
            $position
        );
    }

    protected function makeSupplementalWage(
        GeoPoint $location,
        int $amount_in_cents
    ): Wage {
        return new Wage(
            WageType::SUPPLEMENTAL,
            Carbon::now(),
            $location,
            $amount_in_cents,
            0,
            0,
            0,
            collect([])
        );
    }

    protected function makeWageAtDate(
        Carbon $date,
        GeoPoint $location,
        int $amount_in_cents = UnitTestCase::DEFAULT_SHIFT_WAGES,
        ?int $position = UnitTestCase::DEFAULT_POSITION
    ): Wage {
        return new Wage(
            WageType::SHIFT,
            $date,
            $location,
            $amount_in_cents,
            0,
            0,
            0,
            collect([]),
            $position
        );
    }

    protected function makeAdjustmentWageAtDate(
        Carbon $date,
        GeoPoint $location,
        int $amount_in_cents,
        ?int $position = UnitTestCase::DEFAULT_POSITION
    ): Wage {
        return new Wage(
            WageType::ADJUSTMENT,
            $date,
            $location,
            $amount_in_cents,
            0,
            0,
            0,
            collect([]),
            $position
        );
    }

    protected function makeSalary(
        GeoPoint $location,
        int $amount_in_cents = UnitTestCase::DEFAULT_SHIFT_WAGES,
        int $pay_check_tip_amount_in_cents = null,
        int $take_home_tip_amount_in_cents = null,
        ?int $minutes_worked = UnitTestCase::DEFAULT_MINUTES_WORKED,
        ?int $position = UnitTestCase::DEFAULT_POSITION
    ): Wage {
        return new Wage(
            WageType::SALARY,
            Carbon::now(),
            $location,
            $amount_in_cents,
            $pay_check_tip_amount_in_cents === null ? 0 : $pay_check_tip_amount_in_cents,
            $take_home_tip_amount_in_cents === null ? 0 : $take_home_tip_amount_in_cents,
            $minutes_worked === null ? UnitTestCase::DEFAULT_MINUTES_WORKED : $minutes_worked,
            collect([]),
            $position
        );
    }

    protected function makeWorkersCompRate(
        int $id,
        string $state,
        int $position,
        string $class_code,
        string $sub_code,
        float $employer_amount,
        float $employee_amount
    ): WorkerCompRate {
        return new WorkerCompRate($id, $state, $position, $class_code, $sub_code, $employer_amount, $employee_amount);
    }
}
