<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Oregon\V20190101;

use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome;
use Appleton\Taxes\Countries\US\Oregon\OregonIncome\OregonIncome;
use Appleton\Taxes\Models\Countries\US\Oregon\OregonIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class OregonIncomeTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.oregon';
    private const TAX_CLASS = OregonIncome::class;
    private const TAX_INFO_CLASS = OregonIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(FederalIncome::class);
        $this->query_runner->addTax(self::TAX_CLASS);

        OregonIncomeTaxInformation::createForUser([
            'filing_status' => OregonIncome::FILING_SINGLE,
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
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(2013)
                    ->build()
            ],
            '02' => [
                $builder
                    ->setTaxInfoOptions(['exemptions' => 2])
                    ->setWagesInCents(60000)
                    ->setExpectedAmountInCents(3597)
                    ->build()
            ],
            '03' => [
                $builder
                    ->setTaxInfoOptions(['exemptions' => 3])
                    ->setWagesInCents(120000)
                    ->setExpectedAmountInCents(6690)
                    ->build()
            ],
            '04' => [
                $builder
                    ->setTaxInfoOptions(['filing_status' => OregonIncome::FILING_MARRIED])
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(6137)
                    ->build()
            ],
            '05' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => OregonIncome::FILING_MARRIED,
                        'exemptions' => 4,
                    ])
                    ->setWagesInCents(200000)
                    ->setExpectedAmountInCents(13494)
                    ->build()
            ],
            '06' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => OregonIncome::FILING_MARRIED,
                        'exemptions' => 4,
                        'additional_withholding' => 20,
                    ])
                    ->setWagesInCents(200000)
                    ->setExpectedAmountInCents(15494)
                    ->build()
            ],
            '07' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => OregonIncome::FILING_MARRIED,
                        'exemptions' => 4,
                    ])
                    ->setWagesInCents(500000)
                    ->setExpectedAmountInCents(41777)
                    ->build()
            ],
        ];
    }
}
