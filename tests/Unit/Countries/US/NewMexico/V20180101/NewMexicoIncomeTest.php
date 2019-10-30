<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\NewMexico\V20190101;

use Appleton\Taxes\Countries\US\NewMexico\NewMexicoIncome\NewMexicoIncome;
use Appleton\Taxes\Models\Countries\US\NewMexico\NewMexicoIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class NewMexicoIncomeTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.new_mexico';
    private const TAX_CLASS = NewMexicoIncome::class;
    private const TAX_INFO_CLASS = NewMexicoIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        NewMexicoIncomeTaxInformation::createForUser([
            'filing_status' => NewMexicoIncome::FILING_SINGLE,
            'exemptions' => 0,
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
                    ->setWagesInCents(10000)
                    ->setExpectedAmountInCents(49)
                    ->build()
            ],
            'exemptions' => [
                $builder
                    ->setTaxInfoOptions(['exemptions' => 3])
                    ->setWagesInCents(40000)
                    ->setExpectedAmountInCents(152)
                    ->build()
            ],
            'exemptions locked to max of 3' => [
                $builder
                    ->setTaxInfoOptions(['exemptions' => 5])
                    ->setWagesInCents(40000)
                    ->setExpectedAmountInCents(152)
                    ->build()
            ],
        ];
    }
}
