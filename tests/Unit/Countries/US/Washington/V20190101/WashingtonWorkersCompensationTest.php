<?php

namespace Appleton\Taxes\Countries\US\Washington\V20190101;

use Appleton\Taxes\Classes\WorkerTaxes\GeoPoint;
use Appleton\Taxes\Countries\US\Washington\WashingtonWorkersCompensation\WashingtonWorkersCompensation;
use Appleton\Taxes\Models\Countries\US\Washington\WashingtonWorkersCompensationTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;

class WashingtonWorkersCompensationTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const WASHINGTON_LOCATION = 'us.washington';
    private const TAX_CLASS = WashingtonWorkersCompensation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        WashingtonWorkersCompensationTaxInformation::createForUser([
            'employee_rate' => 100,
            'employer_rate' => 100,
        ], $this->user);
    }

    /**
     * @dataProvider provideTestData
     */
    public function testWashingtonWorkersCompensationTax(TestParameters $parameters): void
    {
        $this->validate($parameters);
    }

    public function provideTestData(): array
    {
        $builder = new TestParametersBuilder();
        $builder
            ->setDate(self::DATE)
            ->setTaxClass(self::TAX_CLASS)
            ->setPayPeriods(52)
            ->setWorkersCompRates(collect([
                $this->makeWorkersCompRate(42, 'WA', 1, '4567', '01', 100, 100),
                $this->makeWorkersCompRate(43, 'WA', 2, '4567', '01', 200, 200)
            ]));

        $geo_point = new GeoPoint(
            $this->getLocation(self::WASHINGTON_LOCATION)[0],
            $this->getLocation(self::WASHINGTON_LOCATION)[1]
        );

        $hourly_wage_1 = $this->makeWage($geo_point, 35000, 0, 0, 480, 1);
        $hourly_wage_2 = $this->makeWage($geo_point, 35000, 0, 0, 480, 2);
        $salary_wage = $this->makeSalary($geo_point, 100000, 0, 0, 2400);

        return [
            'hourly' => [
                $builder
                    ->setHomeLocation(self::WASHINGTON_LOCATION)
                    ->setWorkLocation(self::WASHINGTON_LOCATION)
                    ->setWagesInCents(35000)
                    ->setExpectedAmountsInCents([800])
                    ->setExpectedEarningsInCents(35000)
                    ->setWagesCallback(function ($parameters, $wages) use ($geo_point, $hourly_wage_1) {
                        $wages->push($hourly_wage_1);
                    })
                    ->build()
            ],
            'salary' => [
                $builder
                    ->setHomeLocation(self::WASHINGTON_LOCATION)
                    ->setWorkLocation(self::WASHINGTON_LOCATION)
                    ->setExpectedAmountsInCents([4000])
                    ->setExpectedEarningsInCents(100000)
                    ->setMinutesWorked(2400)
                    ->setWagesCallback(function ($parameters, $wages) use ($geo_point, $salary_wage) {
                        $wages->push($salary_wage);
                    })
                    ->build()
            ],
            'hourly and salary' => [
                $builder
                    ->setHomeLocation(self::WASHINGTON_LOCATION)
                    ->setWorkLocation(self::WASHINGTON_LOCATION)
                    ->setExpectedAmountsInCents([4000 + 800])
                    ->setExpectedEarningsInCents(100000 + 35000)
                    ->setWagesCallback(function ($parameters, $wages) use ($geo_point, $hourly_wage_1, $salary_wage) {
                        $wages->push($hourly_wage_1);
                        $wages->push($salary_wage);
                    })
                    ->build()
            ],
            'multiple rates' => [
                $builder
                    ->setHomeLocation(self::WASHINGTON_LOCATION)
                    ->setWorkLocation(self::WASHINGTON_LOCATION)
                    ->setPaycheckTipAmount(0)
                    ->setTakehomeTipAmount(0)
                    ->setMinutesWorked(480)
                    ->setExpectedAmountsInCents([800, 1600])
                    ->setExpectedEarningsInCents(35000)
                    ->setWagesCallback(function ($parameters, $wages) use ($geo_point, $hourly_wage_1, $hourly_wage_2) {
                        $wages->push($hourly_wage_1);
                        $wages->push($hourly_wage_2);
                    })
                    ->build()
            ],
        ];
    }
}
