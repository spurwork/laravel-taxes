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
            ->setPayPeriods(52);

        return [
            '00' => [
                $builder
                    ->setHomeLocation(self::WASHINGTON_LOCATION)
                    ->setWorkLocation(self::WASHINGTON_LOCATION)
                    ->setWagesInCents(35000)
                    ->setPaycheckTipAmount(625)
                    ->setTakehomeTipAmount(500)
                    ->setExpectedAmountInCents(800)
                    ->build()
            ],
            '01' => [
                $builder
                    ->setHomeLocation(self::WASHINGTON_LOCATION)
                    ->setWorkLocation(self::WASHINGTON_LOCATION)
                    ->setExpectedAmountInCents(4000)
                    ->setWagesCallback(function ($parameters, $wages) {
                        $wages->push($this->makeSalary(new GeoPoint($this->getLocation($parameters->getWorkLocation())[0], $this->getLocation($parameters->getWorkLocation())[1]), $parameters->getWagesInCents(), $parameters->getPaycheckTipAmountInCents(), $parameters->getTakeHomeTipAmountInCents(), $parameters->getMinutesWorked()));
                    })
                    ->build()
            ],
        ];
    }
}
