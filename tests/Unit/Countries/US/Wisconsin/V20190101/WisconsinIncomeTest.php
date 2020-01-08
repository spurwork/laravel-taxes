<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Wisconsin\V20190101;

use Appleton\Taxes\Countries\US\Wisconsin\WisconsinIncome\WisconsinIncome;
use Appleton\Taxes\Models\Countries\US\Wisconsin\WisconsinIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class WisconsinIncomeTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.wisconsin';
    private const TAX_CLASS = WisconsinIncome::class;
    private const TAX_INFO_CLASS = WisconsinIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        WisconsinIncomeTaxInformation::createForUser([
            'filing_status' => WisconsinIncome::FILING_SINGLE,
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
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(5686)
                    ->build()
            ],
            '01' => [
                $builder
                    ->setTaxInfoOptions(['filing_status' => WisconsinIncome::FILING_MARRIED])
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(5492)
                    ->build()
            ],
            '02' => [
                $builder
                    ->setTaxInfoOptions(['filing_status' => WisconsinIncome::FILING_SEPERATE])
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(5881)
                    ->build()
            ],
            'exemptions' => [
                $builder
                    ->setTaxInfoOptions(['exemptions' => 1])
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(5638)
                    ->build()
            ],
            'exempt true' => [
                $builder
                    ->setTaxInfoOptions([
                        'exemptions' => 1,
                        'exempt' => true,
                    ])
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            'exempt false' => [
                $builder
                    ->setTaxInfoOptions([
                        'exemptions' => 1,
                        'exempt' => false,
                    ])
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(5638)
                    ->build()
            ],
        ];
    }
}
