<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Indiana\V20190101;

use Appleton\Taxes\Countries\US\Indiana\IndianaIncome\IndianaIncome;
use Appleton\Taxes\Models\Countries\US\Indiana\IndianaIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class IndianaIncomeTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.indiana';
    private const TAX_CLASS = IndianaIncome::class;
    private const TAX_INFO_CLASS = IndianaIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        IndianaIncomeTaxInformation::createForUser([
            'personal_exemptions' => 0,
            'dependent_exemptions' => 0,
            'additional_withholding' => 0,
            'additional_county_withholding' => 0,
            'county_lived' => 22,
            'county_worked' => 33,
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

    public static function provideTestData(): array
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
                    ->setTaxInfoOptions(['personal_exemptions' => 1])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(906)
                    ->build()
            ],
            'test case 02' => [
                $builder
                    ->setTaxInfoOptions([
                        'personal_exemptions' => 1,
                        'dependent_exemptions' => 1,
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(813)
                    ->build()
            ],
            'test case 03' => [
                $builder
                    ->setTaxInfoOptions([
                        'personal_exemptions' => 1,
                        'dependent_exemptions' => 2,
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(720)
                    ->build()
            ],
            'test case 04' => [
                $builder
                    ->setTaxInfoOptions([
                        'personal_exemptions' => 2,
                        'dependent_exemptions' => 1,
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(751)
                    ->build()
            ],
            'test case 05' => [
                $builder
                    ->setTaxInfoOptions(['dependent_exemptions' => 1])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(875)
                    ->build()
            ],
            'exempt' => [
                $builder
                    ->setTaxInfoOptions(['exempt' => true])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            'additional withholding' => [
                $builder
                    ->setTaxInfoOptions(['additional_withholding' => 10])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(1969)
                    ->build()
            ],
        ];
    }
}
