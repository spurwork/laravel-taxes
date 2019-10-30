<?php

namespace Appleton\Taxes\Classes\WorkerTaxes;

use Appleton\Taxes\Models\GovernmentalUnitArea;

class Payroll
{
    public $birth_date;
    public $date;
    public $days_worked;
    public $earnings;
    public $exemptions;
    public $pay_periods;
    public $supplemental_earnings;
    public $user;
    public $wtd_earnings;
    public $mtd_earnings;
    public $ytd_earnings;
    public $exempted_earnings;
    public $exempted_supplemental_earnings;

    private $amount_withheld;
    private $start_date;
    private $end_date;
    private $area_incomes;
    private $home_areas;
    private $total_earnings;
    private $wage_manager;

    public function __construct(array $parameters, WageManager $wage_manager)
    {
        $this->birth_date = $parameters['birth_date'] ?? null;
        $this->days_worked = $parameters['days_worked'] ?? false;
        $this->earnings = $parameters['earnings'] ?? 0;
        $this->exemptions = collect($parameters['exemptions'] ?? []);
        $this->pay_periods = $parameters['pay_periods'] ?? 52;
        $this->supplemental_earnings = $parameters['supplemental_earnings'] ?? 0;
        $this->user = $parameters['user'];
        $this->wtd_earnings = $parameters['wtd_earnings'] ?? 0;
        $this->mtd_earnings = $parameters['mtd_earnings'] ?? 0;
        $this->ytd_earnings = $parameters['ytd_earnings'] ?? 0;
        $this->exempted_earnings = $parameters['exempted_earnings'] ?? 0;
        $this->exempted_supplemental_earnings = $parameters['exempted_supplemental_earnings'] ?? 0;

        $this->start_date = $parameters['start_date'];
        $this->end_date = $parameters['end_date'] ?? $parameters['start_date'];
        $this->area_incomes = $parameters['area_incomes'] ?? collect([]);
        $this->home_areas = $parameters['home_areas'] ?? collect([]);
        $this->total_earnings = $parameters['total_earnings'] ?? 0;

        $this->amount_withheld = 0;
        $this->wage_manager = $wage_manager;
    }

    public function getStartDate()
    {
        return $this->start_date;
    }

    public function withholdTax(?float $amount): ?float
    {
        $amount = min($this->getNetEarnings(), $amount);
        $this->amount_withheld += $amount;
        return $amount;
    }

    public function getNetEarnings(): float
    {
        return max($this->total_earnings - $this->exempted_earnings - $this->amount_withheld, 0);
    }

    public function getEarnings(GovernmentalUnitArea $governmental_unit_area = null): float
    {
        if ($governmental_unit_area === null) {
            return $this->earnings - $this->exempted_earnings;
        }

        /** @var AreaIncome $area_wages */
        $area_wages = $this->area_incomes->get($governmental_unit_area->name);
        if ($area_wages === null) {
            return 0;
        }

        $earnings_in_cents = $area_wages->getWages()->sum(static function (Wage $gross_wage) {
            return $gross_wage->getAmountInCents();
        });

        return ($earnings_in_cents / 100) - $this->exempted_earnings;
    }

    public function getSupplementalEarnings(): float
    {
        return $this->supplemental_earnings - $this->exempted_supplemental_earnings;
    }

    public function getDaysWorked(string $tax_class, GovernmentalUnitArea $governmental_unit_area = null)
    {
        if ($governmental_unit_area === null) {
            return $this->days_worked;
        }

        /** @var AreaIncome $area_income */
        $area_income = $this->area_incomes->get($governmental_unit_area->name);
        if ($area_income === null) {
            return 0;
        }

        return $this->wage_manager->calculateDaysWorked(
            $area_income->getWages(),
            $this->start_date,
            $this->end_date
        );
    }

    public function getMtdEarnings(GovernmentalUnitArea $governmental_unit_area = null): float
    {
        if ($governmental_unit_area === null) {
            return $this->mtd_earnings;
        }

        /** @var AreaIncome $area_income */
        $area_income = $this->area_incomes->get($governmental_unit_area->name);
        if ($area_income === null) {
            return 0;
        }

        $start_of_month = $this->start_date->copy()->startOfMonth();
        $start_of_year = $this->start_date->copy()->startOfYear();

        return $this->wage_manager->calculateEarnings($area_income->getHistoricalWages(),
            $start_of_month < $start_of_year ? $start_of_year : $start_of_month);
    }

    public function getYtdEarnings(GovernmentalUnitArea $governmental_unit_area = null): float
    {
        if ($governmental_unit_area === null) {
            return $this->ytd_earnings;
        }

        /** @var AreaIncome $area_income */
        $area_income = $this->area_incomes->get($governmental_unit_area->name);
        if ($area_income === null) {
            return 0;
        }

        return $this->wage_manager->calculateEarnings($area_income->getHistoricalWages(),
            $this->start_date->copy()->startOfYear());
    }

    public function determineEarnings(TaxableIncome $taxable_income): void
    {
        $this->earnings = $this->wage_manager->calculateEarnings($taxable_income->getWages());

        $this->exempted_earnings = min($taxable_income->getExemptionAmountInCents() / 100, $this->earnings);
        $this->exempted_supplemental_earnings = min(($taxable_income->getExemptionAmountInCents() / 100) - $this->exempted_earnings,
            $this->supplemental_earnings);

        $start_of_year = $this->start_date->copy()->startOfYear();
        $this->ytd_earnings = $this->wage_manager->calculateEarnings($taxable_income->getHistoricalWages(),
            $start_of_year);

        $start_of_month = $this->start_date->copy()->startOfMonth();
        $this->mtd_earnings = $this->wage_manager->calculateEarnings($taxable_income->getHistoricalWages(),
            $start_of_month < $start_of_year ? $start_of_year : $start_of_month);

        $this->supplemental_earnings = $this->wage_manager->calculateEarnings($taxable_income->getWages(),
            null, true);
    }

    public function hasWorkInArea(string $area_name): bool
    {
        return $this->area_incomes->has($area_name);
    }

    public function livesInArea(string $area_name): bool
    {
        return $this->home_areas->has($area_name);
    }

    public function removeWages(string $area_name): void
    {
        /** @var AreaIncome $area_income */
        $area_income = $this->area_incomes->get($area_name);
        if ($area_income === null) {
            return;
        }

        $this->earnings -= $this->wage_manager->calculateEarnings($area_income->getWages());

        $start_of_year = $this->start_date->copy()->startOfYear();
        $this->ytd_earnings -= $this->wage_manager->calculateEarnings($area_income->getHistoricalWages(),
            $start_of_year);

        $start_of_month = $this->start_date->copy()->startOfMonth();
        $this->mtd_earnings -= $this->wage_manager->calculateEarnings($area_income->getHistoricalWages(),
            $start_of_month < $start_of_year ? $start_of_year : $start_of_month);
    }
}