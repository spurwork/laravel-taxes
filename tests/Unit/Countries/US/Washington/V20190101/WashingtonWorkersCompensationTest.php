<?php

namespace Appleton\Taxes\Countries\US\Washington\V20190101;

use Appleton\Taxes\Classes\WorkerTaxes\GeoPoint;
use Appleton\Taxes\Classes\WorkerTaxes\WorkerCompRate;
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
            ->setPayPeriods(52);

        return [
            '00' => [
                $builder
                    ->setHomeLocation(self::WASHINGTON_LOCATION)
                    ->setWorkLocation(self::WASHINGTON_LOCATION)
                    ->setWagesInCents(35000)
                    ->setPaycheckTipAmount(625)
                    ->setTakehomeTipAmount(500)
                    ->setExpectedAmountsInCents([800])
                    ->setWorkersCompRates(collect([
                        $this->makeWorkersCompRate('WA', 1, '4567', '01', 100, 100)
                    ]))
                    ->build()
            ],
            '01' => [
                $builder
                    ->setHomeLocation(self::WASHINGTON_LOCATION)
                    ->setWorkLocation(self::WASHINGTON_LOCATION)
                    ->setExpectedAmountsInCents([4000])
                    ->setMinutesWorked(2400)
                    ->setWagesCallback(function ($parameters, $wages) {
                        $wages->push($this->makeSalary(new GeoPoint($this->getLocation($parameters->getWorkLocation())[0], $this->getLocation($parameters->getWorkLocation())[1]), $parameters->getWagesInCents(), $parameters->getPaycheckTipAmountInCents(), $parameters->getTakeHomeTipAmountInCents(), $parameters->getMinutesWorked()));
                    })
                    ->build()
            ],
            '02' => [
                $builder
                    ->setHomeLocation(self::WASHINGTON_LOCATION)
                    ->setWorkLocation(self::WASHINGTON_LOCATION)
                    ->setPaycheckTipAmount(0)
                    ->setTakehomeTipAmount(0)
                    ->setMinutesWorked(480)
                    ->setWorkersCompRates(collect([
                        $this->makeWorkersCompRate('WA', 1, '4567', '01', 100, 100),
                        $this->makeWorkersCompRate('WA', 2, '4567', '01', 200, 200)
                    ]))
                    ->setExpectedAmountsInCents([800, 1600])
                    ->setExpectedEarningsInCents(35000)
                    ->setWagesCallback(function ($parameters, $wages) {
                        $point = new GeoPoint(
                            $this->getLocation($parameters->getWorkLocation())[0],
                            $this->getLocation($parameters->getWorkLocation())[1]
                        );
                        $wages->push(
                            $this->makeWage(
                                $point,
                                $parameters->getWagesInCents(),
                                $parameters->getPaycheckTipAmountInCents(),
                                $parameters->getTakeHomeTipAmountInCents(),
                                $parameters->getMinutesWorked(),
                                1
                            )
                        );
                        $wages->push(
                            $this->makeWage(
                                $point,
                                $parameters->getWagesInCents(),
                                $parameters->getPaycheckTipAmountInCents(),
                                $parameters->getTakeHomeTipAmountInCents(),
                                $parameters->getMinutesWorked(),
                                2
                            )
                        );
                    })
                    ->build()
            ],
        ];
    }
}
