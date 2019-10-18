<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\WashingtonDC\V20190101;

use Appleton\Taxes\Countries\US\WashingtonDC\WashingtonDCIncome\WashingtonDCIncome;
use Appleton\Taxes\Models\Countries\US\WashingtonDC\WashingtonDCIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\IncomeParameters;
use Appleton\Taxes\Tests\Unit\Countries\IncomeParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class WashingtonDCIncomeTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.washingtondc';
    private const TAX_CLASS = WashingtonDCIncome::class;
    private const TAX_INFO_CLASS = WashingtonDCIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        WashingtonDCIncomeTaxInformation::createForUser([
            'filing_status' => WashingtonDCIncome::FILING_SINGLE,
            'dependents' => 0,
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
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(null)
                    ->build()
            ],
            '01' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(1415)
                    ->build()
            ],
            '02' => [
                $builder
                    ->setTaxInfoOptions(['dependents' => 2])
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(4693)
                    ->build()
            ],
            '03' => [
                $builder
                    ->setTaxInfoOptions(['dependents' => 2])
                    ->setWagesInCents(200000)
                    ->setExpectedAmountInCents(12566)
                    ->build()
            ],
            '04' => [
                $builder
                    ->setTaxInfoOptions(['filing_status' => WashingtonDCIncome::FILING_MARRIED_FILING_JOINTLY])
                    ->setWagesInCents(350000)
                    ->setExpectedAmountInCents(26673)
                    ->build()
            ],
            '05' => [
                $builder
                    ->setTaxInfoOptions(['filing_status' => WashingtonDCIncome::FILING_MARRIED_FILING_SEPARATELY])
                    ->setWagesInCents(10000)
                    ->setExpectedAmountInCents(400)
                    ->build()
            ],
        ];
    }
}
