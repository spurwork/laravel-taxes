<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Indiana\V20191001;

use Appleton\Taxes\Countries\US\Indiana\OwenIncome\OwenIncome;
use Appleton\Taxes\Models\Countries\US\Indiana\IndianaIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class OwenIncomeTest extends TaxTestCase
{
    private const DATE = '2019-10-01';
    private const LOCATION = 'us.indiana';
    private const TAX_CLASS = OwenIncome::class;
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
            'county_lived' => 0,
            'county_worked' => 0,
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
            'county lived' => [
                $builder
                    ->setTaxInfoOptions([
                        'county_lived' => 60,
                        'county_worked' => 2,
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(420)
                    ->build()
            ],
            'county worked but taxes taken from home county' => [
                $builder
                    ->setTaxInfoOptions([
                        'county_lived' => 2,
                        'county_worked' => 60,
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(null)
                    ->build()
            ],
            'county worked and taxes not taken from home county' => [
                $builder
                    ->setTaxInfoOptions([
                        'county_lived' => 0,
                        'county_worked' => 60,
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(420)
                    ->build()
            ],
        ];
    }
}
