<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Ohio\V20190101\local\sd;

use Appleton\Taxes\Countries\US\Ohio\UpperSanduskyEVSD\UpperSanduskyEVSDTax;
use Appleton\Taxes\Models\Countries\US\Ohio\OhioIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\IncomeParameters;
use Appleton\Taxes\Tests\Unit\Countries\IncomeParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class UpperSanduskyEVSDTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.ohio';
    private const TAX_CLASS = UpperSanduskyEVSDTax::class;
    private const TAX_INFO_CLASS = OhioIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        OhioIncomeTaxInformation::createForUser([
            'dependents' => 0,
            'school_district_id' => '8803',
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
                    ->setWagesInCents(5000)
                    ->setExpectedAmountInCents(null)
                    ->build()
            ],
            '01' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(50000)
                    ->setExpectedAmountInCents(625)
                    ->build()
            ],
            '02' => [
                $builder
                    ->setTaxInfoOptions(['dependents' => 2])
                    ->setWagesInCents(50000)
                    ->setExpectedAmountInCents(594)
                    ->build()
            ],
            '03' => [
                $builder
                    ->setTaxInfoOptions([
                        'dependents' => 2,
                        'school_district_id' => '0000',
                    ])
                    ->setWagesInCents(50000)
                    ->setExpectedAmountInCents(null)
                    ->build()
            ],
        ];
    }

}
