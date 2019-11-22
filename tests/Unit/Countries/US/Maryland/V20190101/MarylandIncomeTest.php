<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Maryland\V20190101;

use Appleton\Taxes\Countries\US\Maryland\MarylandIncome\MarylandIncome;
use Appleton\Taxes\Models\Countries\US\FederalIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\Maryland\MarylandIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class MarylandIncomeTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.maryland';
    private const TAX_CLASS = MarylandIncome::class;
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

    /**
     * @dataProvider provideTestData
     */
    public function testTax(TestParameters $parameters): void
    {
        $this->validate($parameters);
    }

    public function testTax_use_default(): void
    {
        FederalIncomeTaxInformation::forUser($this->user)->delete();

        $this->validate(
            (new TestParametersBuilder())
                ->setDate(self::DATE)
                ->setHomeLocation(self::LOCATION)
                ->setTaxClass(self::TAX_CLASS)
                ->setTaxInfoClass(self::TAX_INFO_CLASS)
                ->setPayPeriods(52)
                ->setWagesInCents(10000)
                ->setExpectedAmountInCents(337)
                ->build()
        );
    }

    public function testTax_work_in_delaware(): void
    {
        FederalIncomeTaxInformation::forUser($this->user)->delete();

        $this->validate(
            (new TestParametersBuilder())
                ->setDate(self::DATE)
                ->setHomeLocation(self::LOCATION)
                ->setWorkLocation('us.delaware')
                ->setTaxClass(self::TAX_CLASS)
                ->setTaxInfoClass(self::TAX_INFO_CLASS)
                ->setPayPeriods(52)
                ->setWagesInCents(30000)
                ->setExpectedAmountInCents(1731)
                ->build()
        );
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
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(1219)
                    ->build()
            ],
            '01' => [
                $builder
                    ->setTaxInfoOptions(['dependents' => 2])
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(3959)
                    ->build()
            ],
            '02' => [
                $builder
                    ->setTaxInfoOptions(['dependents' => 2])
                    ->setWagesInCents(200000)
                    ->setExpectedAmountInCents(8709)
                    ->build()
            ],
            '03' => [
                $builder
                    ->setTaxInfoOptions(['filing_status' => MarylandIncome::FILING_MARRIED_HEAD_OF_HOUSEHOLD])
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(4544)
                    ->build()
            ],
            '04' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => MarylandIncome::FILING_MARRIED_HEAD_OF_HOUSEHOLD,
                        'dependents' => 2,
                    ])
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(3959)
                    ->build()
            ],
            '05' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => MarylandIncome::FILING_MARRIED_HEAD_OF_HOUSEHOLD,
                        'dependents' => 0,
                    ])
                    ->setWagesInCents(200000)
                    ->setExpectedAmountInCents(9294)
                    ->build()
            ],
            '06' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => MarylandIncome::FILING_MARRIED_HEAD_OF_HOUSEHOLD,
                        'dependents' => 2,
                    ])
                    ->setWagesInCents(200000)
                    ->setExpectedAmountInCents(8709)
                    ->build()
            ],
            '07' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(10000)
                    ->setExpectedAmountInCents(337)
                    ->build()
            ],
        ];
    }
}
