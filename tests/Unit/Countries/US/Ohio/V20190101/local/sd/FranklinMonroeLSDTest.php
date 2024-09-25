<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Ohio\V20190101\local\sd;

use Appleton\Taxes\Countries\US\Ohio\FranklinMonroeLSD\FranklinMonroeLSDTax;
use Appleton\Taxes\Models\Countries\US\Ohio\OhioIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class FranklinMonroeLSDTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.ohio';
    private const TAX_CLASS = FranklinMonroeLSDTax::class;
    private const TAX_INFO_CLASS = OhioIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        OhioIncomeTaxInformation::createForUser([
            'dependents' => 0,
            'school_district_id' => '1903',
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

    public function testTax_different_district(): void
    {
        $this->validateNoTax((new TestParametersBuilder())
            ->setDate(self::DATE)
            ->setHomeLocation(self::LOCATION)
            ->setTaxClass(self::TAX_CLASS)
            ->setTaxInfoClass(self::TAX_INFO_CLASS)
            ->setPayPeriods(52)
            ->setTaxInfoOptions([
                'school_district_id' => '0000',
            ])
            ->setWagesInCents(50000)
            ->build()
        );
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
            '00' => [
                $builder
                    ->setTaxInfoOptions(['exempt' => true])
                    ->setWagesInCents(5000)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            '01' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(50000)
                    ->setExpectedAmountInCents(375)
                    ->build()
            ],
            '02' => [
                $builder
                    ->setTaxInfoOptions(['dependents' => 2])
                    ->setWagesInCents(50000)
                    ->setExpectedAmountInCents(356)
                    ->build()
            ],
        ];
    }

}
