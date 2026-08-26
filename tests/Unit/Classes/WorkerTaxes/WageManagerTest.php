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
    public function testSalaryDaysUseMondayAsTheStartOfTheWeek(): void
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
            Carbon::parse('2026-08-28'),
        );

        self::assertSame(5, $days_worked);
    }
}
