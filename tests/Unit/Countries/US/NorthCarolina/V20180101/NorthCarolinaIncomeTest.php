<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\NorthCarolina\V20180101;

use Appleton\Taxes\Countries\US\NorthCarolina\NorthCarolinaIncome\NorthCarolinaIncome;
use Appleton\Taxes\Models\Countries\US\NorthCarolina\NorthCarolinaIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\IncomeParameters;
use Appleton\Taxes\Tests\Unit\Countries\IncomeParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class NorthCarolinaIncomeTest extends TaxTestCase
{
    private const DATE = '2018-01-01';
    private const LOCATION = 'us.north_carolina';
    private const TAX_CLASS = NorthCarolinaIncome::class;
    private const TAX_INFO_CLASS = NorthCarolinaIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        NorthCarolinaIncomeTaxInformation::createForUser([
            'filing_status' => NorthCarolinaIncome::FILING_SINGLE,
            'dependents' => 0,
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

    /**
     * @dataProvider provideUseDefaultTestData
     */
    public function testTax_use_default(IncomeParameters $parameters): void
    {
        NorthCarolinaIncomeTaxInformation::forUser($this->user)->delete();

        $this->validate($parameters);
    }

    public function testTax_supplemental(): void
    {
        $this->validate(
            (new IncomeParametersBuilder())
                ->setDate(self::DATE)
                ->setHomeLocation(self::LOCATION)
                ->setTaxClass(self::TAX_CLASS)
                ->setTaxInfoClass(self::TAX_INFO_CLASS)
                ->setPayPeriods(1)
                ->setWagesInCents(10000)
                ->setSupplementalWagesInCents(10000)
                ->setExpectedAmountInCents(559)
                ->build()
        );
    }

    public function provideTestData(): array
    {
        $builder = new IncomeParametersBuilder();
        $builder
            ->setDate(self::DATE)
            ->setHomeLocation(self::LOCATION)
            ->setTaxClass(self::TAX_CLASS)
            ->setTaxInfoClass(self::TAX_INFO_CLASS)
            ->setPayPeriods(260);

        return [
            '00' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(6668)
                    ->setExpectedAmountInCents(181)
                    ->build()
            ],
            'additional withholding no wages' => [
                $builder
                    ->setTaxInfoOptions(['additional_withholding' => 10])
                    ->setWagesInCents(0)
                    ->setExpectedAmountInCents(null)
                    ->build()
            ],
            'additional withholding' => [
                $builder
                    ->setTaxInfoOptions(['additional_withholding' => 10])
                    ->setWagesInCents(6668)
                    ->setExpectedAmountInCents(1181)
                    ->build()
            ],
            'non negative' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(1000)
                    ->setExpectedAmountInCents(null)
                    ->build()
            ],
        ];
    }

    public function provideUseDefaultTestData(): array
    {
        $builder = new IncomeParametersBuilder();
        $builder
            ->setDate(self::DATE)
            ->setHomeLocation(self::LOCATION)
            ->setTaxClass(self::TAX_CLASS)
            ->setTaxInfoClass(self::TAX_INFO_CLASS)
            ->setPayPeriods(260);

        return [
            '00' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(0)
                    ->setExpectedAmountInCents(null)
                    ->build()
            ],
            '01' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(6668)
                    ->setExpectedAmountInCents(181)
                    ->build()
            ],
        ];
    }
}
