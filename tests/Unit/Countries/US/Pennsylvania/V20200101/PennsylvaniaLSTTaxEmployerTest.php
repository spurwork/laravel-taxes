<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Pennsylvania\V20200101;

use Appleton\Taxes\Countries\US\Pennsylvania\PennsylvaniaLSTTaxEmployer\PennsylvaniaLSTTaxEmployer;
use Appleton\Taxes\Models\Countries\US\Pennsylvania\PennsylvaniaIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;

class PennsylvaniaLSTTaxEmployerTest extends TaxTestCase
{
    private const DATE = '2020-01-01';
    private const LOCATION = 'us.pennsylvania';
    private const TAX_CLASS = PennsylvaniaLSTTaxEmployer::class;
    private const TAX_INFO_CLASS = PennsylvaniaIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        PennsylvaniaIncomeTaxInformation::createForUser([
            'exempt' => false,
            'exempt_from_municipal_lst' => false,
            'exempt_from_school_district_lst' => false,
            'municipal_lst_total' => 0,
            'school_district_lst_total' => 0,
            'lst_paid_to_previous_employers' => 0,
        ], $this->user);
    }

    /** @dataProvider dataProvider */
    public function testLiability(TestParameters $parameters): void
    {
        $this->validate($parameters);
    }

    public function dataProvider(): array
    {
        $builder = new TestParametersBuilder();
        $builder
            ->setDate(self::DATE)
            ->setHomeLocation(self::LOCATION)
            ->setWorkLocation(self::LOCATION)
            ->setPayPeriods(52)
            ->setTaxClass(self::TAX_CLASS)
            ->setTaxInfoClass(self::TAX_INFO_CLASS);

        return [
            'situation 1' => [
                $builder
                    ->setWagesInCents(0)
                    ->setYtdLiabilitiesInCents(0)
                    ->setExpectedAmountInCents(0)
                    ->build(),
            ],
            'situation 2' => [
                $builder
                    ->setTaxInfoOptions([
                        'municipal_lst_total' => 5,
                        'school_district_lst_total' => 4,
                        'exempt_from_municipal_lst' => true,
                        'exempt_from_school_district_lst' => true,
                    ])
                    ->setWagesInCents(0)
                    ->setYtdLiabilitiesInCents(0)
                    ->setExpectedAmountInCents(0)
                    ->build(),
            ],
            'situation 3' => [
                $builder
                    ->setTaxInfoOptions([
                        'municipal_lst_total' => 5,
                        'school_district_lst_total' => 4,
                        'exempt_from_municipal_lst' => true,
                        'exempt_from_school_district_lst' => false,
                    ])
                    ->setWagesInCents(0)
                    ->setYtdLiabilitiesInCents(0)
                    ->setExpectedAmountInCents(400)
                    ->build(),
            ],
            'situation 4' => [
                $builder
                    ->setTaxInfoOptions([
                        'municipal_lst_total' => 5,
                        'school_district_lst_total' => 4,
                        'exempt_from_municipal_lst' => false,
                        'exempt_from_school_district_lst' => false,
                        'lst_paid_to_previous_employers' => 10,
                    ])
                    ->setWagesInCents(0)
                    ->setYtdLiabilitiesInCents(0)
                    ->setExpectedAmountInCents(900)
                    ->build(),
            ],
            'situation 4b' => [
                $builder
                    ->setTaxInfoOptions([
                        'municipal_lst_total' => 5,
                        'school_district_lst_total' => 4,
                        'exempt_from_municipal_lst' => false,
                        'exempt_from_school_district_lst' => false,
                        'lst_paid_to_previous_employers' => 45,
                    ])
                    ->setWagesInCents(0)
                    ->setYtdLiabilitiesInCents(0)
                    ->setExpectedAmountInCents(700)
                    ->build(),
            ],
            'situation 4c' => [
                $builder
                    ->setTaxInfoOptions([
                        'municipal_lst_total' => 5,
                        'school_district_lst_total' => 4,
                        'exempt_from_municipal_lst' => false,
                        'exempt_from_school_district_lst' => false,
                        'lst_paid_to_previous_employers' => 52,
                    ])
                    ->setWagesInCents(0)
                    ->setYtdLiabilitiesInCents(0)
                    ->setExpectedAmountInCents(0)
                    ->build(),
            ],
            'situation 5' => [
                $builder
                    ->setTaxInfoOptions([
                        'municipal_lst_total' => 32,
                        'school_district_lst_total' => 20,
                        'exempt_from_municipal_lst' => false,
                        'exempt_from_school_district_lst' => false,
                        'lst_paid_to_previous_employers' => 10,
                    ])
                    ->setWagesInCents(0)
                    ->setYtdLiabilitiesInCents(0)
                    ->setExpectedAmountInCents(81)
                    ->build(),
            ],
            'situation 5b' => [
                $builder
                    ->setTaxInfoOptions([
                        'municipal_lst_total' => 32,
                        'school_district_lst_total' => 20,
                        'exempt_from_municipal_lst' => false,
                        'exempt_from_school_district_lst' => false,
                        'lst_paid_to_previous_employers' => 45,
                    ])
                    ->setWagesInCents(0)
                    ->setYtdLiabilitiesInCents(0)
                    ->setExpectedAmountInCents(13)
                    ->build(),
            ],
            'situation 5c' => [
                $builder
                    ->setTaxInfoOptions([
                        'municipal_lst_total' => 32,
                        'school_district_lst_total' => 20,
                        'exempt_from_municipal_lst' => false,
                        'exempt_from_school_district_lst' => false,
                        'lst_paid_to_previous_employers' => 52,
                    ])
                    ->setWagesInCents(0)
                    ->setYtdLiabilitiesInCents(0)
                    ->setExpectedAmountInCents(0)
                    ->build(),
            ],
        ];
    }
}
