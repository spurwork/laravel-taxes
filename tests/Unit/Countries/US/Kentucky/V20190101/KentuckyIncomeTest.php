<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Kentucky\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\KentuckyIncome\KentuckyIncome;
use Appleton\Taxes\Models\Countries\US\Kentucky\KentuckyIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class KentuckyIncomeTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.kentucky';
    private const TAX_CLASS = KentuckyIncome::class;
    private const TAX_INFO_CLASS = KentuckyIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        KentuckyIncomeTaxInformation::createForUser([
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

    public function provideTestData(): array
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
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(16668)
                    ->setExpectedAmountInCents(584)
                    ->build()
            ],
            'have not met standard deduction' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(4660)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            'meet standard deduction' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(4981)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            'exceed standard deduction' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(5301)
                    ->setExpectedAmountInCents(16)
                    ->build()
            ],
            'exempt' => [
                $builder
                    ->setTaxInfoOptions(['exempt' => true])
                    ->setWagesInCents(16668)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
        ];
    }
}
