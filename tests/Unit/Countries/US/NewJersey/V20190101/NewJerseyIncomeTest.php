<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\NewJersey\V20190101;

use Appleton\Taxes\Countries\US\NewJersey\NewJerseyIncome\NewJerseyIncome;
use Appleton\Taxes\Models\Countries\US\NewJersey\NewJerseyIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class NewJerseyIncomeTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.new_jersey';
    private const TAX_CLASS = NewJerseyIncome::class;
    private const TAX_INFO_CLASS = NewJerseyIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        NewJerseyIncomeTaxInformation::createForUser([
            'filing_status' => NewJerseyIncome::FILING_SINGLE,
            'exemptions' => 0,
            'tax_rate_table' => null,
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
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(450)
                    ->build()
            ],
            '01' => [
                $builder
                    ->setTaxInfoOptions(['exempt' => true])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            '02' => [
                $builder
                    ->setTaxInfoOptions(['exemptions' => 2])
                    ->setWagesInCents(150000)
                    ->setExpectedAmountInCents(5769)
                    ->build()
            ],
            '03' => [
                $builder
                    ->setTaxInfoOptions(['filing_status' => NewJerseyIncome::FILING_MARRIED_CIVIL_UNION_COUPLE_JOINT])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(450)
                    ->build()
            ],
            '04' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NewJerseyIncome::FILING_MARRIED_CIVIL_UNION_COUPLE_JOINT,
                        'exemptions' => 2,
                    ])
                    ->setWagesInCents(150000)
                    ->setExpectedAmountInCents(3219)
                    ->build()
            ],
            '05' => [
                $builder
                    ->setTaxInfoOptions(['filing_status' => NewJerseyIncome::FILING_MARRIED_CIVIL_UNION_COUPLE_SEPARATE])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(450)
                    ->build()
            ],
            '06' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NewJerseyIncome::FILING_MARRIED_CIVIL_UNION_COUPLE_SEPARATE,
                        'exemptions' => 2,
                    ])
                    ->setWagesInCents(150000)
                    ->setExpectedAmountInCents(5769)
                    ->build()
            ],
            '07' => [
                $builder
                    ->setTaxInfoOptions(['filing_status' => NewJerseyIncome::FILING_HEAD_OF_HOUSEHOLD])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(450)
                    ->build()
            ],
            '08' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NewJerseyIncome::FILING_HEAD_OF_HOUSEHOLD,
                        'exemptions' => 2,
                    ])
                    ->setWagesInCents(150000)
                    ->setExpectedAmountInCents(3219)
                    ->build()
            ],
            '09' => [
                $builder
                    ->setTaxInfoOptions(['filing_status' => NewJerseyIncome::SURVIVING_SPOUSE_SURVIVING_CIVIL_UNION_PARENT])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(450)
                    ->build()
            ],
            '10' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NewJerseyIncome::SURVIVING_SPOUSE_SURVIVING_CIVIL_UNION_PARENT,
                        'exemptions' => 12,
                    ])
                    ->setWagesInCents(150000)
                    ->setExpectedAmountInCents(2561)
                    ->build()
            ],
            '11' => [
                $builder
                    ->setTaxInfoOptions(['tax_rate_table' => 'A'])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(450)
                    ->build()
            ],
            '12' => [
                $builder
                    ->setTaxInfoOptions([
                        'tax_rate_table' => 'A',
                        'exempt' => true,

                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            '13' => [
                $builder
                    ->setTaxInfoOptions([
                        'tax_rate_table' => 'A',
                        'exemptions' => 2,
                    ])
                    ->setWagesInCents(150000)
                    ->setExpectedAmountInCents(5769)
                    ->build()
            ],
            '14' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NewJerseyIncome::FILING_MARRIED_CIVIL_UNION_COUPLE_JOINT,
                        'tax_rate_table' => 'B',
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(450)
                    ->build()
            ],
            '15' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NewJerseyIncome::FILING_MARRIED_CIVIL_UNION_COUPLE_JOINT,
                        'exemptions' => 2,
                        'tax_rate_table' => 'B',
                    ])
                    ->setWagesInCents(150000)
                    ->setExpectedAmountInCents(3219)
                    ->build()
            ],
            '16' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NewJerseyIncome::FILING_MARRIED_CIVIL_UNION_COUPLE_SEPARATE,
                        'tax_rate_table' => 'C',
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(450)
                    ->build()
            ],
            '17' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NewJerseyIncome::FILING_MARRIED_CIVIL_UNION_COUPLE_SEPARATE,
                        'exemptions' => 2,
                        'tax_rate_table' => 'C',
                    ])
                    ->setWagesInCents(150000)
                    ->setExpectedAmountInCents(4396)
                    ->build()
            ],
            '18' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NewJerseyIncome::FILING_HEAD_OF_HOUSEHOLD,
                        'tax_rate_table' => 'D',
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(450)
                    ->build()
            ],
            '19' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NewJerseyIncome::FILING_HEAD_OF_HOUSEHOLD,
                        'exemptions' => 2,
                        'tax_rate_table' => 'D',
                    ])
                    ->setWagesInCents(150000)
                    ->setExpectedAmountInCents(4819)
                    ->build()
            ],
            '20' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NewJerseyIncome::SURVIVING_SPOUSE_SURVIVING_CIVIL_UNION_PARENT,
                        'tax_rate_table' => 'E',
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(450)
                    ->build()
            ],
            '21' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NewJerseyIncome::SURVIVING_SPOUSE_SURVIVING_CIVIL_UNION_PARENT,
                        'exemptions' => 2,
                        'tax_rate_table' => 'E',
                    ])
                    ->setWagesInCents(150000)
                    ->setExpectedAmountInCents(5726)
                    ->build()
            ],
            '22' => [
                $builder
                    ->setTaxInfoOptions(['exemptions' => 2])
                    ->setWagesInCents(150000)
                    ->setExpectedAmountInCents(5769)
                    ->build()
            ],
            '23' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NewJerseyIncome::FILING_MARRIED_CIVIL_UNION_COUPLE_JOINT,
                        'tax_rate_table' => 'OTHER',
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(450)
                    ->build()
            ],
            '24' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NewJerseyIncome::FILING_MARRIED_CIVIL_UNION_COUPLE_JOINT,
                        'exemptions' => 2,
                        'tax_rate_table' => 'OTHER',
                    ])
                    ->setWagesInCents(150000)
                    ->setExpectedAmountInCents(3219)
                    ->build()
            ],
            '25' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NewJerseyIncome::FILING_MARRIED_CIVIL_UNION_COUPLE_SEPARATE,
                        'tax_rate_table' => 'OTHER',
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(450)
                    ->build()
            ],
            '26' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NewJerseyIncome::FILING_MARRIED_CIVIL_UNION_COUPLE_SEPARATE,
                        'exemptions' => 2,
                        'tax_rate_table' => 'OTHER',
                    ])
                    ->setWagesInCents(150000)
                    ->setExpectedAmountInCents(5769)
                    ->build()
            ],
            '27' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NewJerseyIncome::FILING_HEAD_OF_HOUSEHOLD,
                        'tax_rate_table' => 'OTHER',
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(450)
                    ->build()
            ],
            '28' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NewJerseyIncome::FILING_HEAD_OF_HOUSEHOLD,
                        'exemptions' => 2,
                        'tax_rate_table' => 'OTHER',
                    ])
                    ->setWagesInCents(150000)
                    ->setExpectedAmountInCents(3219)
                    ->build()
            ],
            '29' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NewJerseyIncome::SURVIVING_SPOUSE_SURVIVING_CIVIL_UNION_PARENT,
                        'tax_rate_table' => 'OTHER',
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(450)
                    ->build()
            ],
            '30' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NewJerseyIncome::SURVIVING_SPOUSE_SURVIVING_CIVIL_UNION_PARENT,
                        'exemptions' => 12,
                        'tax_rate_table' => 'OTHER',
                    ])
                    ->setWagesInCents(150000)
                    ->setExpectedAmountInCents(2561)
                    ->build()
            ],
        ];
    }
}
