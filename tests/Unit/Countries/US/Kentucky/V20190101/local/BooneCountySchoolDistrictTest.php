<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Kentucky\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\BooneCountySchoolDistrict\BooneCountySchoolDistrict;
use Appleton\Taxes\Models\Countries\US\Kentucky\KentuckyIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class BooneCountySchoolDistrictTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.kentucky.boone_county';
    private const TAX_CLASS = BooneCountySchoolDistrict::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);
    }

    public function testTax_lives_in_bcsd(): void
    {
        KentuckyIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'exempt' => false,
            'lives_in_bcsd' => true,
        ], $this->user);

        $this->validate(
            (new TestParametersBuilder())
                ->setDate(self::DATE)
                ->setHomeLocation(self::LOCATION)
                ->setTaxClass(self::TAX_CLASS)
                ->setPayPeriods(52)
                ->setWagesInCents(30000)
                ->setExpectedAmountInCents(150)
                ->build()
        );
    }

    public function testTax_does_not_live_in_bcsd(): void
    {
        KentuckyIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'exempt' => false,
            'lives_in_bcsd' => false,
        ], $this->user);

        $this->validateNoTax(
            (new TestParametersBuilder())
                ->setDate(self::DATE)
                ->setHomeLocation(self::LOCATION)
                ->setTaxClass(self::TAX_CLASS)
                ->setPayPeriods(52)
                ->setWagesInCents(30000)
                ->build()
        );
    }
}
