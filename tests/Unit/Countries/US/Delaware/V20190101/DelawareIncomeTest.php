<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Delaware\V20190101;

use Appleton\Taxes\Countries\US\Delaware\DelawareIncome\DelawareIncome;
use Appleton\Taxes\Models\Countries\US\Delaware\DelawareIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class DelawareIncomeTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.delaware';
    private const TAX_CLASS = DelawareIncome::class;
    private const TAX_INFO_CLASS = DelawareIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        DelawareIncomeTaxInformation::createForUser([
            'filing_status' => DelawareIncome::FILING_SINGLE,
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
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            '01' => [
                $builder
                    ->setTaxInfoOptions(['filing_status' => DelawareIncome::FILING_MARRIED_FILING_SEPARATELY])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(719)
                    ->build()
            ],
            '02' => [
                $builder
                    ->setTaxInfoOptions(['filing_status' => DelawareIncome::FILING_MARRIED_FILING_JOINTLY])
                    ->setWagesInCents(70000)
                    ->setExpectedAmountInCents(2448)
                    ->build()
            ],
            '03' => [
                $builder
                    ->setTaxInfoOptions(['filing_status' => DelawareIncome::FILING_MARRIED_FILING_SEPARATELY])
                    ->setWagesInCents(3500)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            '04' => [
                $builder
                    ->setTaxInfoOptions(['filing_status' => DelawareIncome::FILING_MARRIED_FILING_SEPARATELY])
                    ->setWagesInCents(15000)
                    ->setExpectedAmountInCents(108)
                    ->build()
            ],
            '05' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => DelawareIncome::FILING_MARRIED_FILING_SEPARATELY,
                        'exemptions' => 2,
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(296)
                    ->build()
            ],
            '06' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => DelawareIncome::FILING_SINGLE,
                        'exemptions' => 2,
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(296)
                    ->build()
            ],
            '07' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => DelawareIncome::FILING_SINGLE,
                        'exemptions' => 2,
                        'additional_withholding' => 20,
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(2296)
                    ->build()
            ],
        ];
    }
}
