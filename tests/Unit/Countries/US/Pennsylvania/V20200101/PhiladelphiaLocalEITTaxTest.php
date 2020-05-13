<?php

namespace Appleton\Taxes\Countries\US\Pennsylvania\V20200101;

use Appleton\Taxes\Countries\US\Pennsylvania\PhiladelphiaLocalEITTax\PhiladelphiaLocalEITTax;
use Appleton\Taxes\Models\Countries\US\Pennsylvania\PennsylvaniaIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;

class PhiladelphiaLocalEITTaxTest extends TaxTestCase
{
    private const DATE = '2020-01-01';
    private const PENNSYLVANIA_LOCATION = 'us.pennsylvania';
    private const ALABAMA_LOCATION = 'us.alabama';
    private const TAX_CLASS = PhiladelphiaLocalEITTax::class;
    private const TAX_INFO_CLASS = PennsylvaniaIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        PennsylvaniaIncomeTaxInformation::createForUser([
            'exempt' => false,
            'resident_eit_rate' => null,
            'employer_eit_rate' => null,
            'is_resident_psd_code_philadelphia' => false,
            'is_employer_psd_code_philadelphia' => false,
        ], $this->user);
    }

    /**
     * @dataProvider provideTestData
     */
    public function testPhiladelphiaLocalEITTax(TestParameters $parameters): void
    {
        $this->validate($parameters);
    }

    /**
     * @dataProvider provideTestDataOutOfArea
     */
    public function testPhiladelphiaLocalEITTaxOutOfArea(TestParameters $parameters): void
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
            'lives and works in philadelphia' => [
                $builder
                    ->setTaxInfoOptions([
                        'is_resident_psd_code_philadelphia' => true,
                        'is_employer_psd_code_philadelphia' => true,
                        'resident_eit_rate' => 1.5,
                        'employer_eit_rate' => .5,
                    ])
                    ->setHomeLocation(self::PENNSYLVANIA_LOCATION)
                    ->setWorkLocation(self::PENNSYLVANIA_LOCATION)
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(450)
                    ->build()
            ],
            'lives in philadelphia' => [
                $builder
                    ->setTaxInfoOptions([
                        'is_resident_psd_code_philadelphia' => true,
                        'is_employer_psd_code_philadelphia' => false,
                        'resident_eit_rate' => 1.5,
                        'employer_eit_rate' => .5,
                    ])
                    ->setHomeLocation(self::PENNSYLVANIA_LOCATION)
                    ->setWorkLocation(self::PENNSYLVANIA_LOCATION)
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(450)
                    ->build()
            ],
            'works in philadelphia' => [
                $builder
                    ->setTaxInfoOptions([
                        'is_resident_psd_code_philadelphia' => false,
                        'is_employer_psd_code_philadelphia' => true,
                        'resident_eit_rate' => 1.5,
                        'employer_eit_rate' => .5,
                    ])
                    ->setHomeLocation(self::PENNSYLVANIA_LOCATION)
                    ->setWorkLocation(self::PENNSYLVANIA_LOCATION)
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(150)
                    ->build()
            ],
            'doesnt live or work in philadelphia' => [
                $builder
                    ->setTaxInfoOptions([
                        'is_resident_psd_code_philadelphia' => false,
                        'is_employer_psd_code_philadelphia' => false,
                        'resident_eit_rate' => 1.5,
                        'employer_eit_rate' => .5,
                    ])
                    ->setHomeLocation(self::PENNSYLVANIA_LOCATION)
                    ->setWorkLocation(self::PENNSYLVANIA_LOCATION)
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            'psd is empty' => [
                $builder
                    ->setTaxInfoOptions([
                        'is_resident_psd_code_philadelphia' => false,
                        'is_employer_psd_code_philadelphia' => false,
                        'resident_eit_rate' => 1.5,
                        'employer_eit_rate' => .5,
                    ])
                    ->setHomeLocation(self::PENNSYLVANIA_LOCATION)
                    ->setWorkLocation(self::PENNSYLVANIA_LOCATION)
                    ->setWagesInCents(30000)
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
