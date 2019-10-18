<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Nebraska\V20190101;

use Appleton\Taxes\Countries\US\Nebraska\NebraskaIncome\NebraskaIncome;
use Appleton\Taxes\Models\Countries\US\Nebraska\NebraskaIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\IncomeParameters;
use Appleton\Taxes\Tests\Unit\Countries\IncomeParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class NebraskaIncomeTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.nebraska';
    private const TAX_CLASS = NebraskaIncome::class;
    private const TAX_INFO_CLASS = NebraskaIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        NebraskaIncomeTaxInformation::createForUser([
            'filing_status' => NebraskaIncome::FILING_SINGLE,
            'allowances' => 0,
            'lower_withholding_than_lb223' => false,
            'exempt' => false,
        ], $this->user);
    }

    /**
     * @dataProvider provideTestData
     */
    public function testTax(IncomeParameters $parameters): void
    {
        $this->validate($parameters);
    }

    public function provideTestData(): array
    {
        $builder = new IncomeParametersBuilder();
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
                    ->setExpectedAmountInCents(736)
                    ->build()
            ],
            '02' => [
                $builder
                    ->setTaxInfoOptions(['allowances' => 1])
                    ->setWagesInCents(70000)
                    ->setExpectedAmountInCents(2671)
                    ->build()
            ],
            '03' => [
                $builder
                    ->setTaxInfoOptions(['allowances' => 2])
                    ->setWagesInCents(150000)
                    ->setExpectedAmountInCents(7782)
                    ->build()
            ],
            '04' => [
                $builder
                    ->setTaxInfoOptions(['allowances' => 3])
                    ->setWagesInCents(300000)
                    ->setExpectedAmountInCents(17945)
                    ->build()
            ],
            '05' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NebraskaIncome::FILING_MARRIED,
                        'allowances' => 2,
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(219)
                    ->build()
            ],
            '06' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NebraskaIncome::FILING_MARRIED,
                        'allowances' => 2,
                    ])
                    ->setWagesInCents(70000)
                    ->setExpectedAmountInCents(1704)
                    ->build()
            ],
            '07' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NebraskaIncome::FILING_MARRIED,
                        'allowances' => 11,
                    ])
                    ->setWagesInCents(150000)
                    ->setExpectedAmountInCents(4388)
                    ->build()
            ],
            '08' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NebraskaIncome::FILING_MARRIED,
                        'allowances' => 3,
                    ])
                    ->setWagesInCents(300000)
                    ->setExpectedAmountInCents(16831)
                    ->build()
            ],
            '09' => [
                $builder
                    ->setTaxInfoOptions(['filing_status' => NebraskaIncome::FILING_HEAD_OF_HOUSEHOLD])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(736)
                    ->build()
            ],
            '10' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NebraskaIncome::FILING_HEAD_OF_HOUSEHOLD,
                        'allowances' => 1,
                    ])
                    ->setWagesInCents(70000)
                    ->setExpectedAmountInCents(2671)
                    ->build()
            ],
            '11' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NebraskaIncome::FILING_HEAD_OF_HOUSEHOLD,
                        'allowances' => 2,
                    ])
                    ->setWagesInCents(150000)
                    ->setExpectedAmountInCents(7782)
                    ->build()
            ],
            '12' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NebraskaIncome::FILING_HEAD_OF_HOUSEHOLD,
                        'allowances' => 3,
                    ])
                    ->setWagesInCents(300000)
                    ->setExpectedAmountInCents(17945)
                    ->build()
            ],
            '13' => [
                $builder
                    ->setTaxInfoOptions(['lower_withholding_than_lb223' => true])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(736)
                    ->build()
            ],
            '14' => [
                $builder
                    ->setTaxInfoOptions([
                        'lower_withholding_than_lb223' => true,
                        'allowances' => 1,
                    ])
                    ->setWagesInCents(70000)
                    ->setExpectedAmountInCents(2671)
                    ->build()
            ],
            '15' => [
                $builder
                    ->setTaxInfoOptions([
                        'lower_withholding_than_lb223' => true,
                        'allowances' => 2,
                    ])
                    ->setWagesInCents(150000)
                    ->setExpectedAmountInCents(7782)
                    ->build()
            ],
            '16' => [
                $builder
                    ->setTaxInfoOptions([
                        'lower_withholding_than_lb223' => true,
                        'allowances' => 3,
                    ])
                    ->setWagesInCents(300000)
                    ->setExpectedAmountInCents(17945)
                    ->build()
            ],
            '17' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NebraskaIncome::FILING_MARRIED,
                        'lower_withholding_than_lb223' => true,
                        'allowances' => 2,
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(219)
                    ->build()
            ],
            '18' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NebraskaIncome::FILING_MARRIED,
                        'lower_withholding_than_lb223' => true,
                        'allowances' => 2,
                    ])
                    ->setWagesInCents(70000)
                    ->setExpectedAmountInCents(1704)
                    ->build()
            ],
            '19' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NebraskaIncome::FILING_MARRIED,
                        'lower_withholding_than_lb223' => true,
                        'allowances' => 11,
                    ])
                    ->setWagesInCents(150000)
                    ->setExpectedAmountInCents(4388)
                    ->build()
            ],
            '20' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NebraskaIncome::FILING_MARRIED,
                        'lower_withholding_than_lb223' => true,
                        'allowances' => 3,
                    ])
                    ->setWagesInCents(300000)
                    ->setExpectedAmountInCents(16831)
                    ->build()
            ],
            '21' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NebraskaIncome::FILING_HEAD_OF_HOUSEHOLD,
                        'lower_withholding_than_lb223' => true,
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(736)
                    ->build()
            ],
            '22' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NebraskaIncome::FILING_HEAD_OF_HOUSEHOLD,
                        'lower_withholding_than_lb223' => true,
                        'allowances' => 1,
                    ])
                    ->setWagesInCents(70000)
                    ->setExpectedAmountInCents(2671)
                    ->build()
            ],
            '23' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NebraskaIncome::FILING_HEAD_OF_HOUSEHOLD,
                        'lower_withholding_than_lb223' => true,
                        'allowances' => 2,
                    ])
                    ->setWagesInCents(150000)
                    ->setExpectedAmountInCents(7782)
                    ->build()
            ],
            '24' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NebraskaIncome::FILING_HEAD_OF_HOUSEHOLD,
                        'lower_withholding_than_lb223' => true,
                        'allowances' => 3,
                    ])
                    ->setWagesInCents(300000)
                    ->setExpectedAmountInCents(17945)
                    ->build()
            ],
        ];
    }
}
