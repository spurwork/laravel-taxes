<?php

namespace Appleton\Taxes\Countries\US\Oregon\V20200101;

use Appleton\Taxes\Countries\US\Oregon\WorkersCompAssessmentFund\WorkersCompAssessmentFund;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;

class WorkersCompAssessmentFundTest extends TaxTestCase
{
    private const DATE = '2020-01-01';
    private const OREGON_LOCATION = 'us.oregon';
    private const ALABAMA_LOCATION = 'us.alabama';
    private const TAX_CLASS = WorkersCompAssessmentFund::class;

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
     * @dataProvider provideTestDataOutOfArea
     */

    public function testTaxOutOfArea(TestParameters $parameters): void
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
                    ->setHomeLocation(self::OREGON_LOCATION)
                    ->setWorkLocation(self::OREGON_LOCATION)
                    ->setWagesInCents(1125)
                    ->setMinutesWorked(60)
                    ->setExpectedAmountInCents(110)
                    ->build()
            ],
            '01' => [
                $builder
                    ->setHomeLocation(self::OREGON_LOCATION)
                    ->setWorkLocation(self::OREGON_LOCATION)
                    ->setWagesInCents(1200)
                    ->setMinutesWorked(90)
                    ->setExpectedAmountInCents(165)
                    ->build()
            ],
            '02' => [
                $builder
                    ->setHomeLocation(self::OREGON_LOCATION)
                    ->setWorkLocation(self::OREGON_LOCATION)
                    ->setWagesInCents(1600)
                    ->setMinutesWorked(480)
                    ->setExpectedAmountInCents(880)
                    ->build()
            ],
        ];
    }

    public function provideTestDataOutOfArea(): array
    {
        $builder = new TestParametersBuilder();
        $builder
            ->setDate(self::DATE)
            ->setTaxClass(self::TAX_CLASS)
            ->setPayPeriods(52);

        return [
            '00' => [
                $builder
                    ->setHomeLocation(self::ALABAMA_LOCATION)
                    ->setWorkLocation(self::ALABAMA_LOCATION)
                    ->setWagesInCents(1200)
                    ->setMinutesWorked(60)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            '01' => [
                $builder
                    ->setHomeLocation(self::OREGON_LOCATION)
                    ->setWorkLocation(self::ALABAMA_LOCATION)
                    ->setWagesInCents(1600)
                    ->setMinutesWorked(60)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
        ];
    }
}
