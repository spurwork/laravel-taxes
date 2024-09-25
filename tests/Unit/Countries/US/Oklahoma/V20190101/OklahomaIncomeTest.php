<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Oklahoma\V20190101;

use Appleton\Taxes\Countries\US\Oklahoma\OklahomaIncome\OklahomaIncome;
use Appleton\Taxes\Models\Countries\US\Oklahoma\OklahomaIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class OklahomaIncomeTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.oklahoma';
    private const TAX_CLASS = OklahomaIncome::class;
    private const TAX_INFO_CLASS = OklahomaIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        OklahomaIncomeTaxInformation::createForUser([
            'filing_status' => OklahomaIncome::FILING_SINGLE,
            'dependents' => 0,
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
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(500)
                    ->build()
            ],
            '02' => [
                $builder
                    ->setTaxInfoOptions(['dependents' => 2])
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(3800)
                    ->build()
            ],
            '03' => [
                $builder
                    ->setTaxInfoOptions(['dependents' => 9])
                    ->setWagesInCents(28846)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            '04' => [
                $builder
                    ->setTaxInfoOptions(['filing_status' => OklahomaIncome::FILING_MARRIED])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            '05' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => OklahomaIncome::FILING_MARRIED,
                        'dependents' => 2,
                    ])
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(2900)
                    ->build()
            ],
            '06' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => OklahomaIncome::FILING_MARRIED,
                        'dependents' => 9,
                    ])
                    ->setWagesInCents(28846)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
        ];
    }
}
