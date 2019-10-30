<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Ohio\V20190101\local\sd;

use Appleton\Taxes\Countries\US\Ohio\ElmwoodLSD\ElmwoodLSDTax;
use Appleton\Taxes\Models\Countries\US\Ohio\OhioIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class ElmwoodLSDTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.ohio';
    private const TAX_CLASS = ElmwoodLSDTax::class;
    private const TAX_INFO_CLASS = OhioIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        OhioIncomeTaxInformation::createForUser([
            'dependents' => 0,
            'school_district_id' => '8703',
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