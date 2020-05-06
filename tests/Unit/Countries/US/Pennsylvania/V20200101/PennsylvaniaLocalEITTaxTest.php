<?php

namespace Appleton\Taxes\Countries\US\Pennsylvania\V20200101;

use Appleton\Taxes\Countries\US\Pennsylvania\PennsylvaniaLocalEITTax\PennsylvaniaLocalEITTax;
use Appleton\Taxes\Models\Countries\US\Pennsylvania\PennsylvaniaIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;

class PennsylvaniaLocalEITTaxTest extends TaxTestCase
{
    private const DATE = '2020-01-01';
    private const PENNSYLVANIA_LOCATION = 'us.pennsylvania';
    private const ALABAMA_LOCATION = 'us.alabama';
    private const TAX_CLASS = PennsylvaniaLocalEITTax::class;
    private const TAX_INFO_CLASS = PennsylvaniaIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        PennsylvaniaIncomeTaxInformation::createForUser([
            'exempt' => false,
            'resident_eit' => null,
            'non_resident_eit' => null,
        ], $this->user);
    }

    /**
     * @dataProvider provideTestData
     */
    public function testPennsylvaniaLocalEITTax(TestParameters $parameters): void
    {
        $this->validate($parameters);
    }

    /**
     * @dataProvider provideTestDataOutOfArea
     */
    public function testPennsylvaniaLocalEITTaxOutOfArea(TestParameters $parameters): void
    {
        $this->validate($parameters);
    }

    public function provideTestData(): array
    {
        $builder = new TestParametersBuilder();
        $builder
            ->setDate(self::DATE)
            ->setTaxClass(self::TAX_CLASS)
            ->setTaxInfoClass(self::TAX_INFO_CLASS)
            ->setPayPeriods(52);

        return [
            'resident rate is higher' => [
                $builder
                    ->setTaxInfoOptions([
                        'resident_eit' => 1.5,
                        'non_resident_eit' => .5,
                    ])
                    ->setHomeLocation(self::PENNSYLVANIA_LOCATION)
                    ->setWorkLocation(self::PENNSYLVANIA_LOCATION)
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(450)
                    ->build()
            ],
            'non resident rate is higher' => [
                $builder
                    ->setTaxInfoOptions([
                        'resident_eit' => .1,
                        'non_resident_eit' => .5,
                    ])
                    ->setHomeLocation(self::PENNSYLVANIA_LOCATION)
                    ->setWorkLocation(self::PENNSYLVANIA_LOCATION)
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(150)
                    ->build()
            ],
            'out of state worker' => [
                $builder
                    ->setTaxInfoOptions([
                        'resident_eit' => null,
                        'non_resident_eit' => .5,
                    ])
                    ->setHomeLocation(self::ALABAMA_LOCATION)
                    ->setWorkLocation(self::PENNSYLVANIA_LOCATION)
                    ->setWagesInCents(16000)
                    ->setExpectedAmountInCents(80)
                    ->build()
            ],
            'both null' => [
                $builder
                    ->setTaxInfoOptions([
                        'resident_eit' => null,
                        'non_resident_eit' => null,
                    ])
                    ->setHomeLocation(self::ALABAMA_LOCATION)
                    ->setWorkLocation(self::PENNSYLVANIA_LOCATION)
                    ->setWagesInCents(16000)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            'same rate' => [
                $builder
                    ->setTaxInfoOptions([
                        'resident_eit' => 1.5,
                        'non_resident_eit' => 1.5,
                    ])
                    ->setHomeLocation(self::ALABAMA_LOCATION)
                    ->setWorkLocation(self::PENNSYLVANIA_LOCATION)
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(450)
                    ->build()
            ],
            'exempt' => [
                $builder
                    ->setTaxInfoOptions([
                        'exempt' => true,
                        'resident_eit' => 1.5,
                        'non_resident_eit' => 1.5,
                    ])
                    ->setHomeLocation(self::ALABAMA_LOCATION)
                    ->setWorkLocation(self::PENNSYLVANIA_LOCATION)
                    ->setWagesInCents(16000)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
        ];
    }

    public function provideTestDataOutOfArea(): array
    {
        $builder = new TestParametersBuilder();
        $builder
            ->setDate(self::DATE)
            ->setTaxClass(self::TAX_CLASS)
            ->setPayPeriods(52);

        return [
            '00' => [
                $builder
                    ->setHomeLocation(self::PENNSYLVANIA_LOCATION)
                    ->setWorkLocation(self::ALABAMA_LOCATION)
                    ->setWagesInCents(1200)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            '01' => [
                $builder
                    ->setHomeLocation(self::ALABAMA_LOCATION)
                    ->setWorkLocation(self::ALABAMA_LOCATION)
                    ->setWagesInCents(1600)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
        ];
    }
}
