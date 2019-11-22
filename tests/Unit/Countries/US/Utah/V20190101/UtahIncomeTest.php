<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Utah\V20190101;

use Appleton\Taxes\Countries\US\Utah\UtahIncome\UtahIncome;
use Appleton\Taxes\Models\Countries\US\Utah\UtahIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class UtahIncomeTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.utah';
    private const TAX_CLASS = UtahIncome::class;
    private const TAX_INFO_CLASS = UtahIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        UtahIncomeTaxInformation::createForUser([
            'filing_status' => UtahIncome::FILING_SINGLE,
            'additional_withholding' => 0,
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
                    ->setWagesInCents(40000)
                    ->setExpectedAmountInCents(1629)
                    ->build()
            ],
            '01' => [
                $builder
                    ->setTaxInfoOptions(['filing_status' => UtahIncome::FILING_MARRIED])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(134)
                    ->build()
            ],
            '02' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => UtahIncome::FILING_MARRIED,
                        'additional_withholding' => 20,
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(2134)
                    ->build()
            ],
            '03' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(1004)
                    ->build()
            ],
        ];
    }
}
