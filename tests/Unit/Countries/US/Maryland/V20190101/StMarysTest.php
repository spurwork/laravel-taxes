<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Maryland\V20190101;

use Appleton\Taxes\Countries\US\Maryland\MarylandIncome\MarylandIncome;
use Appleton\Taxes\Countries\US\Maryland\StMarys\StMarys;
use Appleton\Taxes\Models\Countries\US\Maryland\MarylandIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class StMarysTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const HOME_LOCATION = 'us.maryland.stmarys';
    private const WORK_LOCATION = 'us.maryland';
    private const TAX_CLASS = StMarys::class;
    private const TAX_INFO_CLASS = MarylandIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        MarylandIncomeTaxInformation::createForUser([
            'filing_status' => MarylandIncome::FILING_SINGLE,
            'dependents' => 0,
            'additional_withholding' => 0,
            'exempt' => false,
        ], $this->user);
    }

    public function testTax(): void
    {
        $this->validate(
            (new TestParametersBuilder())
                ->setDate(self::DATE)
                ->setHomeLocation(self::HOME_LOCATION)
                ->setHomeLocation(self::WORK_LOCATION)
                ->setTaxClass(self::TAX_CLASS)
                ->setTaxInfoClass(self::TAX_INFO_CLASS)
                ->setTaxInfoOptions(null)
                ->setPayPeriods(52)
                ->setWagesInCents(10000)
                ->setExpectedAmountInCents(213)
                ->build()
        );
    }
}
