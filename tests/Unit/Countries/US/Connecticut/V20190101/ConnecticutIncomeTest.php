<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Connecticut\V20190101;

use Appleton\Taxes\Countries\US\Connecticut\ConnecticutIncome\ConnecticutIncome;
use Appleton\Taxes\Models\Countries\US\Connecticut\ConnecticutIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class ConnecticutIncomeTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.connecticut';
    private const TAX_CLASS = ConnecticutIncome::class;
    private const TAX_INFO_CLASS = ConnecticutIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        ConnecticutIncomeTaxInformation::createForUser([
            'filing_status' => ConnecticutIncome::WITHHOLDING_CODE_A,
            'reduced_withholding' => 0,
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
                    ->setExpectedAmountInCents(73)
                    ->build()
            ],
            '02' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(57693)
                    ->setExpectedAmountInCents(1817)
                    ->build()
            ],
            '03' => [
                $builder
                    ->setTaxInfoOptions([
                        'reduced_withholding' => 20,
                        'additional_withholding' => 20,
                    ])
                    ->setWagesInCents(57693)
                    ->setExpectedAmountInCents(1817)
                    ->build()
            ],
            '04' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(115380)
                    ->setExpectedAmountInCents(5634)
                    ->build()
            ],
            '05' => [
                $builder
                    ->setTaxInfoOptions(['filing_status' => ConnecticutIncome::WITHHOLDING_CODE_B])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            '06' => [
                $builder
                    ->setTaxInfoOptions(['filing_status' => ConnecticutIncome::WITHHOLDING_CODE_B])
                    ->setWagesInCents(57693)
                    ->setExpectedAmountInCents(413)
                    ->build()
            ],
            '07' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => ConnecticutIncome::WITHHOLDING_CODE_B,
                        'reduced_withholding' => 20,
                    ])
                    ->setWagesInCents(57693)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            '08' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => ConnecticutIncome::WITHHOLDING_CODE_B,
                        'additional_withholding' => 20,
                    ])
                    ->setWagesInCents(57693)
                    ->setExpectedAmountInCents(2413)
                    ->build()
            ],
            '09' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => ConnecticutIncome::WITHHOLDING_CODE_B,
                    ])
                    ->setWagesInCents(115380)
                    ->setExpectedAmountInCents(4638)
                    ->build()
            ],
            '10' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => ConnecticutIncome::WITHHOLDING_CODE_B,
                    ])
                    ->setWagesInCents(673080)
                    ->setExpectedAmountInCents(39443)
                    ->build()
            ],
            '11' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => ConnecticutIncome::WITHHOLDING_CODE_C,
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            '12' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => ConnecticutIncome::WITHHOLDING_CODE_C,
                    ])
                    ->setWagesInCents(57693)
                    ->setExpectedAmountInCents(104)
                    ->build()
            ],
            '13' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => ConnecticutIncome::WITHHOLDING_CODE_C,
                    ])
                    ->setWagesInCents(115380)
                    ->setExpectedAmountInCents(3461)
                    ->build()
            ],
            '14' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => ConnecticutIncome::WITHHOLDING_CODE_C,
                    ])
                    ->setWagesInCents(673080)
                    ->setExpectedAmountInCents(37500)
                    ->build()
            ],
            '15' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => ConnecticutIncome::WITHHOLDING_CODE_D,
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(1115)
                    ->build()
            ],
            '16' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => ConnecticutIncome::WITHHOLDING_CODE_D,
                    ])
                    ->setWagesInCents(57693)
                    ->setExpectedAmountInCents(2500)
                    ->build()
            ],
            '17' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => ConnecticutIncome::WITHHOLDING_CODE_D,
                    ])
                    ->setWagesInCents(115380)
                    ->setExpectedAmountInCents(5634)
                    ->build()
            ],
            '18' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => ConnecticutIncome::WITHHOLDING_CODE_D,
                    ])
                    ->setWagesInCents(673080)
                    ->setExpectedAmountInCents(46346)
                    ->build()
            ],
            '19' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => ConnecticutIncome::WITHHOLDING_CODE_F,
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(9)
                    ->build()
            ],
            '20' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => ConnecticutIncome::WITHHOLDING_CODE_F,
                    ])
                    ->setWagesInCents(57693)
                    ->setExpectedAmountInCents(981)
                    ->build()
            ],
            '21' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => ConnecticutIncome::WITHHOLDING_CODE_F,
                    ])
                    ->setWagesInCents(115380)
                    ->setExpectedAmountInCents(4967)
                    ->build()
            ],
            '22' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => ConnecticutIncome::WITHHOLDING_CODE_F,
                    ])
                    ->setWagesInCents(673080)
                    ->setExpectedAmountInCents(46346)
                    ->build()
            ],
            '23' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => ConnecticutIncome::WITHHOLDING_CODE_E,
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            '24' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => ConnecticutIncome::WITHHOLDING_CODE_E,
                    ])
                    ->setWagesInCents(57693)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            '25' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => ConnecticutIncome::WITHHOLDING_CODE_E,
                    ])
                    ->setWagesInCents(115380)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            '26' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => ConnecticutIncome::WITHHOLDING_CODE_E,
                    ])
                    ->setWagesInCents(673080)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
        ];
    }
}
