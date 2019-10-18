<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Illinois\V20190101;

use Appleton\Taxes\Countries\US\Illinois\IllinoisIncome\IllinoisIncome;
use Appleton\Taxes\Models\Countries\US\Illinois\IllinoisIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\IncomeParameters;
use Appleton\Taxes\Tests\Unit\Countries\IncomeParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class IllinoisIncomeTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.illinois';
    private const TAX_CLASS = IllinoisIncome::class;
    private const TAX_INFO_CLASS = IllinoisIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        IllinoisIncomeTaxInformation::createForUser([
            'basic_allowances' => 0,
            'additional_allowances' => 0,
            'additional_withholding' => 0,
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
            'test case 01' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(1485)
                    ->build()
            ],
            'test case 02' => [
                $builder
                    ->setTaxInfoOptions([
                        'basic_allowances' => 2,
                        'additional_allowances' => 1,
                    ])
                    ->setWagesInCents(70000)
                    ->setExpectedAmountInCents(2936)
                    ->build()
            ],
            'test case 03' => [
                $builder
                    ->setTaxInfoOptions([
                        'additional_allowances' => 1,
                    ])
                    ->setWagesInCents(70000)
                    ->setExpectedAmountInCents(3369)
                    ->build()
            ],
            'exempt' => [
                $builder
                    ->setTaxInfoOptions(['exempt' => true])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(null)
                    ->build()
            ],
            'additional withholding' => [
                $builder
                    ->setTaxInfoOptions(['additional_withholding' => 10])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(2485)
                    ->build()
            ],
        ];
    }
}
