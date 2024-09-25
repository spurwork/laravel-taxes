<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\NewYork\V20190101;

use Appleton\Taxes\Countries\US\NewYork\NewYorkFamilyMedicalLeave\NewYorkFamilyMedicalLeave;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\WageBaseTaxTestCase;

class NewYorkFamilyMedicalLeaveTest extends WageBaseTaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.new_york';
    private const TAX_CLASS = NewYorkFamilyMedicalLeave::class;
    private const TAX_RATE = 0.00153;
    private const WAGE_BASE = 135711;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);
    }

    /**
     * @dataProvider provideTestData
     */
    public function testTax(TestParameters $parameters): void
    {
        $this->validate($parameters);
    }

    /**
     * @dataProvider provideWageBaseData
     */
    public function testWageBase(TestParameters $parameters): void
    {
        $this->validateWageBase($parameters);
    }

    public static function provideTestData(): array
    {
        $builder = new TestParametersBuilder();
        $builder
            ->setDate(self::DATE)
            ->setHomeLocation(self::LOCATION)
            ->setTaxClass(self::TAX_CLASS)
            ->setPayPeriods(52);

        return [
            '00' => [
                $builder
                    ->setWagesInCents(0)
                    ->setExpectedAmountInCents(0)
                    ->setExpectedEarningsInCents(null)
                    ->build()
            ],
            '01' => [
                $builder
                    ->setWagesInCents(35000)
                    ->setExpectedAmountInCents(54)
                    ->setExpectedEarningsInCents(35000)
                    ->build()
            ],
            '02' => [
                $builder
                    ->setWagesInCents(140000)
                    ->setExpectedAmountInCents(208)
                    ->setExpectedEarningsInCents(135711)
                    ->build()
            ],
        ];
    }

    public static function provideWageBaseData(): array
    {
        return self::wageBaseBoundariesTestCases(
            self::DATE,
            self::LOCATION,
            self::TAX_CLASS,
            self::WAGE_BASE,
            self::TAX_RATE);
    }
}
