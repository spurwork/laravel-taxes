<?php

namespace Appleton\Taxes\Classes\WorkerTaxes;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class WageManager
{
    public function groupLatLong(Collection $wages): Collection
    {
        $wages_by_lat_long = collect([]);

        $wages->each(static function (Wage $wage) use ($wages_by_lat_long) {
            $lat_long = $wage->getLocation()->toString();

            if (!$wages_by_lat_long->has($lat_long)) {
                $wages_by_lat_long->put($lat_long, collect([]));
            }

            $wages_by_lat_long->get($lat_long)->push($wage);
        });

        return $wages_by_lat_long;
    }

    public function calculateEarnings(
        Collection $wages,
        Carbon $date = null,
        bool $supplemental = false
    ): float {
        if ($supplemental) {
            $filtered_wages = $wages->filter(static function (Wage $wage) {
                return $wage->getType() === WageType::SUPPLEMENTAL;
            });
        } else {
            $filtered_wages = $wages->filter(static function (Wage $wage) {
                return $wage->getType() !== WageType::SUPPLEMENTAL;
            });
        }

        if ($date !== null) {
            $filtered_wages = $filtered_wages->filter(static function (Wage $gross_wage) use ($date) {
                return $gross_wage->getDate() >= $date;
            });
        }

        return $filtered_wages->sum(static function (Wage $gross_wage) {
            return $gross_wage->getAmountInCents();
        }) / 100;
    }

    public function calculateDaysWorked(
        Collection $wages,
        Carbon $start_date,
        Carbon $end_date
    ): int {
        $worked_days = [];

        $wages->each(static function (Wage $wage) use (&$worked_days, $start_date, $end_date) {
            $date = $wage->getDate();
            switch ($wage->getType()) {
                case WageType::SHIFT:
                    if ($date < $start_date
                        || $date > $end_date
                        || in_array($date->toDateString(), $worked_days, true)
                    ) {
                        return;
                    }

                    $worked_days[] = $date->toDateString();
                    return;
                case WageType::SALARY:
                    if ($date < $start_date || $date > $end_date) {
                        return;
                    }

                    $start_of_week = $date->copy()->startOfWeek();
                    for ($i = 0; $i < 5; ++$i) {
                        $day = $start_of_week->copy()->addDays($i);
                        if ($day < $start_date
                            || in_array($day->toDateString(), $worked_days, true)
                        ) {
                            continue;
                        }

                        $worked_days[] = $date->toDateString();
                        continue;
                    }

                    return;
                case WageType::SICK_LEAVE:
                case WageType::ADJUSTMENT:
                case WageType::SUPPLEMENTAL:
                    return;
            }
        });

        return count($worked_days);
    }

    public function calculateTipAmount(Collection $wages)
    {
        return $wages->sum(function (Wage $wage) {
            return $wage->getTakeHomeTipAmountInCents() + $wage->getPayCheckTipAmountInCents();
        });
    }
}
