<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Alabama\V20180101;

use Appleton\Taxes\Countries\US\Alabama\AlabamaIncome\AlabamaIncome;
use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome;
use Appleton\Taxes\Models\Countries\US\Alabama\AlabamaIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\FederalIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\IncomeParameters;
use Appleton\Taxes\Tests\Unit\Countries\IncomeParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class AlabamaIncomeTest extends TaxTestCase
{
    private const DATE = '2018-01-01';
    private const LOCATION = 'us.alabama';
    private const TAX_CLASS = AlabamaIncome::class;
    private const TAX_INFO_CLASS = AlabamaIncomeTaxInformation::class;
    
    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(FederalIncome::class);
        $this->query_runner->addTax(AlabamaIncome::class);

        FederalIncomeTaxInformation::createForUser([
            'filing_status' => FederalIncome::FILING_SINGLE,
            'exemptions' => 0,
            'additional_withholding' => 0,
            'non_resident_alien' => false,
        ], $this->user);

        AlabamaIncomeTaxInformation::createForUser([
            'filing_status' => AlabamaIncome::FILING_SINGLE,
            'dependents' => 0,
            'additional_withholding' => 0,
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
        return [
            '01' => [
                (new IncomeParametersBuilder())
                    ->setDate(self::DATE)
                    ->setHomeLocation(self::LOCATION)
                    ->setTaxClass(self::TAX_CLASS)
                    ->setWagesInCents(6668)
                    ->setPayPeriods(260)
                    ->setExpectedAmountInCents(213)
                    ->build()
            ],
        ];
    }
}
