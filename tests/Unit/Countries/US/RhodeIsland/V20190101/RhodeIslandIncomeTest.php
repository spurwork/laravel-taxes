<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\RhodeIsland\V20190101;

use Appleton\Taxes\Countries\US\RhodeIsland\RhodeIslandIncome\RhodeIslandIncome;
use Appleton\Taxes\Models\Countries\US\RhodeIsland\RhodeIslandIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class RhodeIslandIncomeTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.rhode_island';
    private const TAX_CLASS = RhodeIslandIncome::class;
    private const TAX_INFO_CLASS = RhodeIslandIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        RhodeIslandIncomeTaxInformation::createForUser([
            'exemptions' => 0,
            'additional_withholding' => 0,
            'exempt' => false,
        ], $this->user);
    }

    /**
     * @dataProvider provideTestData
     */
    public function testTax(TestParameters $parameters): void
    {
        $this->validate($parameters);
    }

    public function provideTestData(): array
    {
        $builder = new TestParametersBuilder();
        $builder
            ->setDate(self::DATE)
            ->setHomeLocation(self::LOCATION)
            ->setTaxClass(self::TAX_CLASS)
            ->setTaxInfoClass(self::TAX_INFO_CLASS)
            ->setPayPeriods(52);

        return [
            '00' => [
                $builder
                    ->setTaxInfoOptions(['exempt' => true])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(null)
                    ->build()
            ],
            '01' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(1125)
                    ->build()
            ],
            '02' => [
                $builder
                    ->setTaxInfoOptions(['exemptions' => 2])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(981)
                    ->build()
            ],
            '03' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(134615)
                    ->setExpectedAmountInCents(5162)
                    ->build()
            ],
            '04' => [
                $builder
                    ->setTaxInfoOptions(['exemptions' => 2])
                    ->setWagesInCents(134615)
                    ->setExpectedAmountInCents(4980)
                    ->build()
            ],
            '05' => [
                $builder
                    ->setTaxInfoOptions([
                        'exemptions' => 2,
                        'additional_withholding' => 20
                    ])
                    ->setWagesInCents(134615)
                    ->setExpectedAmountInCents(6980)
                    ->build()
            ],
        ];
    }
}
