<?php

namespace Appleton\Taxes\Tests\Unit\Classes\WorkerTaxes;

use Appleton\Taxes\Classes\WorkerTaxes\GeoPoint;
use Appleton\Taxes\Classes\WorkerTaxes\Wage;
use Appleton\Taxes\Classes\WorkerTaxes\WageManager;
use Appleton\Taxes\Classes\WorkerTaxes\WageType;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class WageManagerTest extends TestCase
{
    /** @dataProvider salaryWeekData */
    public function testSalaryDaysUseMondayAsTheStartOfTheWeek(string $end_date, int $expected_days_worked): void
    {
        $date = Carbon::parse('2026-08-26')->locale('en_US');
        $wage = new Wage(
            WageType::SALARY,
            $date,
            new GeoPoint(0, 0),
            0,
            0,
            0,
            0,
            new Collection(),
        );

        $days_worked = (new WageManager())->calculateDaysWorked(
            new Collection([$wage]),
            Carbon::parse('2026-08-24'),
            Carbon::parse($end_date),
        );

        self::assertSame($expected_days_worked, $days_worked);
    }

    public static function salaryWeekData(): array
    {
        return [
            'full week' => ['2026-08-28', 5],
            'period ending midweek' => ['2026-08-26', 3],
        ];
    }
}
