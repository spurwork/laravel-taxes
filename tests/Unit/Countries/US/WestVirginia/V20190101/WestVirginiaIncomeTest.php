<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\WestVirginia\V20190101;

use Appleton\Taxes\Countries\US\WestVirginia\WestVirginiaIncome\WestVirginiaIncome;
use Appleton\Taxes\Models\Countries\US\WestVirginia\WestVirginiaIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class WestVirginiaIncomeTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.west_virginia';
    private const TAX_CLASS = WestVirginiaIncome::class;
    private const TAX_INFO_CLASS = WestVirginiaIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        WestVirginiaIncomeTaxInformation::createForUser([
            'allowances' => 0,
            'two_earner_percent' => false,
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
            'test case 01' => [
                $builder
                    ->setTaxInfoOptions(['allowances' => 3])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(600)
                    ->build()
            ],
            'test case 02' => [
                $builder
                    ->setTaxInfoOptions(['allowances' => 2])
                    ->setWagesInCents(50000)
                    ->setExpectedAmountInCents(1500)
                    ->build()
            ],
            'test case 03' => [
                $builder
                    ->setTaxInfoOptions(['allowances' => 4])
                    ->setWagesInCents(70000)
                    ->setExpectedAmountInCents(2000)
                    ->build()
            ],
            'test case 04' => [
                $builder
                    ->setTaxInfoOptions(['allowances' => 1])
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(4200)
                    ->build()
            ],
            'test case 05' => [
                $builder
                    ->setTaxInfoOptions(['allowances' => 2])
                    ->setWagesInCents(200000)
                    ->setExpectedAmountInCents(10300)
                    ->build()
            ],
            'test case 06' => [
                $builder
                    ->setTaxInfoOptions([
                        'two_earner_percent' => true,
                        'allowances' => 4,
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(500)
                    ->build()
            ],
            'test case 07' => [
                $builder
                    ->setTaxInfoOptions([
                        'two_earner_percent' => true,
                        'allowances' => 1,
                    ])
                    ->setWagesInCents(50000)
                    ->setExpectedAmountInCents(1800)
                    ->build()
            ],
            'test case 08' => [
                $builder
                    ->setTaxInfoOptions([
                        'two_earner_percent' => true,
                        'allowances' => 2,
                    ])
                    ->setWagesInCents(70000)
                    ->setExpectedAmountInCents(2800)
                    ->build()
            ],
            'test case 09' => [
                $builder
                    ->setTaxInfoOptions([
                        'two_earner_percent' => true,
                        'allowances' => 4,
                    ])
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(4200)
                    ->build()
            ],
            'test case 10' => [
                $builder
                    ->setTaxInfoOptions([
                        'two_earner_percent' => true,
                        'allowances' => 3,
                    ])
                    ->setWagesInCents(200000)
                    ->setExpectedAmountInCents(11000)
                    ->build()
            ],
        ];
    }
}
