<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Missouri\V20190101;

use Appleton\Taxes\Countries\US\Missouri\MissouriIncome\MissouriIncome;
use Appleton\Taxes\Models\Countries\US\Missouri\MissouriIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\IncomeParameters;
use Appleton\Taxes\Tests\Unit\Countries\IncomeParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class MissouriIncomeTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.missouri';
    private const TAX_CLASS = MissouriIncome::class;
    private const TAX_INFO_CLASS = MissouriIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        MissouriIncomeTaxInformation::createForUser([
            'filing_status' => MissouriIncome::FILING_SINGLE,
            'allowances' => 0,
            'additional_withholding' => 0,
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
                    ->setTaxInfoOptions(['filing_status' => MissouriIncome::FILING_MARRIED_FILING_SEPARATE])
                    ->setWagesInCents(60000)
                    ->setExpectedAmountInCents(1600)
                    ->build()
            ],
            '02' => [
                $builder
                    ->setTaxInfoOptions(['filing_status' => MissouriIncome::FILING_MARRIED_BOTH_SPOUSES_EMPLOYED])
                    ->setWagesInCents(10000)
                    ->setExpectedAmountInCents(null)
                    ->build()
            ],
            '03' => [
                $builder
                    ->setTaxInfoOptions(['filing_status' => MissouriIncome::FILING_MARRIED_BOTH_SPOUSES_EMPLOYED])
                    ->setWagesInCents(70000)
                    ->setExpectedAmountInCents(2200)
                    ->build()
            ],
            '04' => [
                $builder
                    ->setTaxInfoOptions(['filing_status' => MissouriIncome::FILING_MARRIED_ONE_SPOUSE_EMPLOYED])
                    ->setWagesInCents(90000)
                    ->setExpectedAmountInCents(2000)
                    ->build()
            ],
            '05' => [
                $builder
                    ->setTaxInfoOptions(['filing_status' => MissouriIncome::FILING_MARRIED_ONE_SPOUSE_EMPLOYED])
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(2500)
                    ->build()
            ],
            '06' => [
                $builder
                    ->setTaxInfoOptions(['filing_status' => MissouriIncome::FILING_HEAD_OF_HOUSEHOLD])
                    ->setWagesInCents(25000)
                    ->setExpectedAmountInCents(null)
                    ->build()
            ],
            '07' => [
                $builder
                    ->setTaxInfoOptions(['filing_status' => MissouriIncome::FILING_MARRIED_ONE_SPOUSE_EMPLOYED])
                    ->setWagesInCents(96154)
                    ->setExpectedAmountInCents(2300)
                    ->build()
            ],
        ];
    }
}
