<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Maine\V20190101;

use Appleton\Taxes\Countries\US\Maine\MaineIncome\MaineIncome;
use Appleton\Taxes\Models\Countries\US\Maine\MaineIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\IncomeParameters;
use Appleton\Taxes\Tests\Unit\Countries\IncomeParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class MaineIncomeTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.maine';
    private const TAX_CLASS = MaineIncome::class;
    private const TAX_INFO_CLASS = MaineIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        MaineIncomeTaxInformation::createForUser([
            'filing_status' => MaineIncome::FILING_SINGLE,
            'allowances' => 0,
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
                    ->setTaxInfoOptions(['allowances' => 2])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(null)
                    ->build()
            ],
            '02' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(700)
                    ->build()
            ],
            '03' => [
                $builder
                    ->setTaxInfoOptions(['allowances' => 2])
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(4000)
                    ->build()
            ],
            '04' => [
                $builder
                    ->setTaxInfoOptions(['allowances' => 2])
                    ->setWagesInCents(200000)
                    ->setExpectedAmountInCents(11400)
                    ->build()
            ],
            '05' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => MaineIncome::FILING_MARRIED,
                        'allowances' => 2,
                    ])
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(2500)
                    ->build()
            ],
            '06' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => MaineIncome::FILING_MARRIED,
                    ])
                    ->setWagesInCents(200000)
                    ->setExpectedAmountInCents(9900)
                    ->build()
            ],
            '07' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => MaineIncome::FILING_MARRIED,
                        'allowances' => 2,
                    ])
                    ->setWagesInCents(200000)
                    ->setExpectedAmountInCents(8800)
                    ->build()
            ],
            '08' => [
                $builder
                    ->setTaxInfoOptions(['allowances' => 2])
                    ->setWagesInCents(80000)
                    ->setExpectedAmountInCents(2700)
                    ->build()
            ],
            '09' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => MaineIncome::FILING_MARRIED,
                        'allowances' => 2,
                    ])
                    ->setWagesInCents(450000)
                    ->setExpectedAmountInCents(27900)
                    ->build()
            ],
        ];
    }
}
