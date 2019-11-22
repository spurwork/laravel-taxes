<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Colorado\V20190101;

use Appleton\Taxes\Countries\US\Colorado\ColoradoIncome\ColoradoIncome;
use Appleton\Taxes\Models\Countries\US\Colorado\ColoradoIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class ColoradoIncomeTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.georgia';
    private const TAX_CLASS = ColoradoIncome::class;
    private const TAX_INFO_CLASS = ColoradoIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(ColoradoIncome::class);

        ColoradoIncomeTaxInformation::createForUser([
            'filing_status' => ColoradoIncome::FILING_SINGLE,
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
            '01' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(4300)
                    ->build()
            ],
            '02' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => ColoradoIncome::FILING_MARRIED
                    ])
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(3600)
                    ->build()
            ],
            'exemptions' => [
                $builder
                    ->setTaxInfoOptions([
                        'exemptions' => 1
                    ])
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(3900)
                    ->build()
            ],
        ];
    }
}
