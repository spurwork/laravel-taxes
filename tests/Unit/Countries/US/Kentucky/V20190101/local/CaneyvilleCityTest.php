<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Kentucky\V20190101;

use Appleton\Taxes\Classes\WorkerTaxes\GeoPoint;
use Appleton\Taxes\Classes\WorkerTaxes\TaxResult;
use Appleton\Taxes\Countries\US\Kentucky\CaneyvilleCity\CaneyvilleCity;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;
use Appleton\Taxes\Tests\Unit\UnitTestCase;
use Carbon\Carbon;
use ReflectionClass;

class CaneyvilleCityTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.kentucky.caneyville_city';
    private const TAX_CLASS = CaneyvilleCity::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);
    }

    public function testTax_no_days_worked(): void
    {
        Carbon::setTestNow(self::DATE);

        $home_location_array = $this->getLocation(self::LOCATION);
        $home_location = new GeoPoint($home_location_array[0], $home_location_array[1]);

        $wage = $this->makeAdjustmentWageAtDate(Carbon::now(), $home_location, 30000);

        $results = $this->taxes->calculate(
            Carbon::now(),
            Carbon::now()->addWeek(),
            $home_location,
            $home_location,
            collect([$wage]),
            collect([]),
            collect([]),
            $this->user,
            null,
            52,
            collect([]),
            collect([]),
            collect([])
        );

        $short_name = (new ReflectionClass(self::TAX_CLASS))->getShortName();
        self::assertNull($results->get(self::TAX_CLASS), "no results for $short_name expected");
    }

    public function testTax_three_days_worked(): void
    {
        Carbon::setTestNow(self::DATE);

        $home_location_array = $this->getLocation(self::LOCATION);
        $home_location = new GeoPoint($home_location_array[0], $home_location_array[1]);

        $wage_1 = $this->makeWageAtDate(Carbon::now(), $home_location);
        $wage_2 = $this->makeWageAtDate(Carbon::now()->addDay(), $home_location);
        $wage_3 = $this->makeWageAtDate(Carbon::now()->addDays(2), $home_location);

        $results = $this->taxes->calculate(
            Carbon::now(),
            Carbon::now()->addWeek(),
            $home_location,
            $home_location,
            collect([$wage_1, $wage_2, $wage_3]),
            collect([]),
            collect([]),
            $this->user,
            null,
            52,
            collect([]),
            collect([]),
            collect([])
        );

        /** @var TaxResult $result */
        $result = $results->get(self::TAX_CLASS);

        $short_name = (new ReflectionClass(self::TAX_CLASS))->getShortName();
        self::assertNotNull($result, 'no tax results for '.$short_name.' found');
        self::assertThat($result->getAmountInCents(), self::identicalTo(200),
            $short_name.' expected '. 200 .' tax but got '.$result->getAmountInCents());
        self::assertThat($result->getEarningsInCents(), self::identicalTo(UnitTestCase::DEFAULT_SHIFT_WAGES * 3),
            $short_name.' expected '.UnitTestCase::DEFAULT_SHIFT_WAGES * 3
            .' earnings but got '.$result->getAmountInCents());
    }

    public function testTax_four_days_worked(): void
    {
        Carbon::setTestNow(self::DATE);

        $home_location_array = $this->getLocation(self::LOCATION);
        $home_location = new GeoPoint($home_location_array[0], $home_location_array[1]);

        $wage_1 = $this->makeWageAtDate(Carbon::now(), $home_location);
        $wage_2 = $this->makeWageAtDate(Carbon::now()->addDay(), $home_location);
        $wage_3 = $this->makeWageAtDate(Carbon::now()->addDays(2), $home_location);
        $wage_4 = $this->makeWageAtDate(Carbon::now()->addDays(3), $home_location);

        $results = $this->taxes->calculate(
            Carbon::now(),
            Carbon::now()->addWeek(),
            $home_location,
            $home_location,
            collect([$wage_1, $wage_2, $wage_3, $wage_4]),
            collect([]),
            collect([]),
            $this->user,
            null,
            52,
            collect([]),
            collect([]),
            collect([])
        );

        /** @var TaxResult $result */
        $result = $results->get(self::TAX_CLASS);

        $short_name = (new ReflectionClass(self::TAX_CLASS))->getShortName();
        self::assertNotNull($result, 'no tax results for '.$short_name.' found');
        self::assertThat($result->getAmountInCents(), self::identicalTo(400),
            $short_name.' expected '. 400 .' tax but got '.$result->getAmountInCents());
        self::assertThat($result->getEarningsInCents(), self::identicalTo(UnitTestCase::DEFAULT_SHIFT_WAGES * 4),
            $short_name.' expected '.UnitTestCase::DEFAULT_SHIFT_WAGES * 4
            .' earnings but got '.$result->getAmountInCents());
    }
}
