<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Mississippi\V20190101;

use Appleton\Taxes\Countries\US\Mississippi\MississippiIncome\MississippiIncome;
use Appleton\Taxes\Models\Countries\US\Mississippi\MississippiIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class MississippiIncomeTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.mississippi';
    private const TAX_CLASS = MississippiIncome::class;
    private const TAX_INFO_CLASS = MississippiIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        MississippiIncomeTaxInformation::createForUser([
            'filing_status' => MississippiIncome::FILING_SINGLE,
            'total_exemption_amount_dollars' => 0,
            'additional_withholding' => 0,
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
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            '01' => [
                $builder
                    ->setTaxInfoOptions(['total_exemption_amount_dollars' => 50])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(900)
                    ->build()
            ],
            '02' => [
                $builder
                    ->setTaxInfoOptions(['total_exemption_amount_dollars' => 4000])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(500)
                    ->build()
            ],
            '03' => [
                $builder
                    ->setTaxInfoOptions(['total_exemption_amount_dollars' => 10000])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(100)
                    ->build()
            ],
            '04' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => MississippiIncome::FILING_MARRIED_ONE_SPOUSE_EMPLOYED,
                        'total_exemption_amount_dollars' => 50,
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(600)
                    ->build()
            ],
            '05' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => MississippiIncome::FILING_MARRIED_ONE_SPOUSE_EMPLOYED,
                        'total_exemption_amount_dollars' => 4000,
                    ])
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(3800)
                    ->build()
            ],
            '06' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => MississippiIncome::FILING_MARRIED_ONE_SPOUSE_EMPLOYED,
                        'total_exemption_amount_dollars' => 10000,
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            '07' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => MississippiIncome::FILING_HEAD_OF_HOUSEHOLD,
                        'total_exemption_amount_dollars' => 50,
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(800)
                    ->build()
            ],
            '08' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => MississippiIncome::FILING_HEAD_OF_HOUSEHOLD,
                        'total_exemption_amount_dollars' => 4000,
                    ])
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(3900)
                    ->build()
            ],
            '09' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => MississippiIncome::FILING_HEAD_OF_HOUSEHOLD,
                        'total_exemption_amount_dollars' => 10000,
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            '10' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => MississippiIncome::FILING_MARRIED_BOTH_SPOUSES_EMPLOYED,
                        'total_exemption_amount_dollars' => 50,
                    ])
                    ->setWagesInCents(60000)
                    ->setExpectedAmountInCents(2100)
                    ->build()
            ],
            '11' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => MississippiIncome::FILING_MARRIED_BOTH_SPOUSES_EMPLOYED,
                        'total_exemption_amount_dollars' => 4000,
                    ])
                    ->setWagesInCents(200000)
                    ->setExpectedAmountInCents(8800)
                    ->build()
            ],
            '12' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => MississippiIncome::FILING_MARRIED_BOTH_SPOUSES_EMPLOYED,
                        'total_exemption_amount_dollars' => 10000,
                    ])
                    ->setWagesInCents(120000)
                    ->setExpectedAmountInCents(4200)
                    ->build()
            ],
        ];
    }
}
