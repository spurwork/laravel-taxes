<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Kentucky\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\ScottCountySchoolDistrict\ScottCountySchoolDistrict;
use Appleton\Taxes\Models\Countries\US\Kentucky\KentuckyIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\IncomeParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class ScottCountySchoolDistrictTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.kentucky.scott_county';
    private const TAX_CLASS = ScottCountySchoolDistrict::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        KentuckyIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'exempt' => false,
        ], $this->user);
    }

    public function testTax_lives_in_scsd(): void
    {
        KentuckyIncomeTaxInformation::forUser($this->user)->update([
            'lives_in_scsd' => true,
        ]);

        $this->validate(
            (new IncomeParametersBuilder())
                ->setDate(self::DATE)
                ->setHomeLocation(self::LOCATION)
                ->setTaxClass(self::TAX_CLASS)
                ->setPayPeriods(52)
                ->setWagesInCents(30000)
                ->setExpectedAmountInCents(150)
                ->build()
        );
    }

    public function testTax_not_live_in_scsd(): void
    {
        KentuckyIncomeTaxInformation::forUser($this->user)->update([
            'lives_in_scsd' => false,
        ]);

        $this->validate(
            (new IncomeParametersBuilder())
                ->setDate(self::DATE)
                ->setHomeLocation(self::LOCATION)
                ->setTaxClass(self::TAX_CLASS)
                ->setPayPeriods(52)
                ->setWagesInCents(30000)
                ->setExpectedAmountInCents(null)
                ->build()
        );
    }

}
