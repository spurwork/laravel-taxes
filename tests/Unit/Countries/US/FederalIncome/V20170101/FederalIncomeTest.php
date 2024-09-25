<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\FederalIncome\V20170101;

use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome;
use Appleton\Taxes\Countries\US\Medicare\Medicare;
use Appleton\Taxes\Countries\US\SocialSecurity\SocialSecurity;
use Appleton\Taxes\Models\Countries\US\FederalIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class FederalIncomeTest extends TaxTestCase
{
    private const DATE = '2017-01-01';
    private const LOCATION = 'us.alabama';
    private const TAX_CLASS = FederalIncome::class;
    private const TAX_INFO_CLASS = FederalIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        FederalIncomeTaxInformation::createForUser([
            'filing_status' => FederalIncome::FILING_SINGLE,
            'exemptions' => 0,
            'additional_withholding' => 0,
            'non_resident_alien' => false,
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

    /**
     * @dataProvider provideAdditionalWithholdingTestData
     */
    public function testTax_additional_withholding(TestParameters $parameters): void
    {
        // these tests rely on SocialSecurity and Medicare being withheld from the payroll
        $this->query_runner->addTax(Medicare::class);
        $this->query_runner->addTax(SocialSecurity::class);

        $this->validate($parameters);
    }

    public static function provideTestData(): array
    {
        $builder = new TestParametersBuilder();
        $builder
            ->setDate(self::DATE)
            ->setHomeLocation(self::LOCATION)
            ->setTaxClass(self::TAX_CLASS)
            ->setTaxInfoClass(self::TAX_INFO_CLASS);

        return [
            'no taxes owed' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setPayPeriods(1)
                    ->setWagesInCents(230000)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            'no taxes owed married' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => FederalIncome::FILING_MARRIED,
                    ])
                    ->setPayPeriods(1)
                    ->setWagesInCents(865000)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            'taxes owed' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setPayPeriods(1)
                    ->setWagesInCents(230100)
                    ->setExpectedAmountInCents(10)
                    ->build()
            ],
            'taxes owed married' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => FederalIncome::FILING_MARRIED,
                    ])
                    ->setPayPeriods(1)
                    ->setWagesInCents(865100)
                    ->setExpectedAmountInCents(10)
                    ->build()
            ],
            'supplemental' => [
                (new TestParametersBuilder())
                    ->setDate(self::DATE)
                    ->setHomeLocation(self::LOCATION)
                    ->setTaxClass(self::TAX_CLASS)
                    ->setTaxInfoOptions(null)
                    ->setPayPeriods(1)
                    ->setWagesInCents(10000)
                    ->setSupplementalWagesInCents(10000)
                    ->setExpectedAmountInCents(2500)
                    ->build()
            ],
            'weekly' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setPayPeriods(52)
                    ->setWagesInCents(230000)
                    ->setExpectedAmountInCents(49664)
                    ->build()
            ],
            'bi-monthly' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setPayPeriods(24)
                    ->setWagesInCents(230000)
                    ->setExpectedAmountInCents(37348)
                    ->build()
            ],
            'monthly' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setPayPeriods(12)
                    ->setWagesInCents(230000)
                    ->setExpectedAmountInCents(27739)
                    ->build()
            ],
            'non-negative' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setPayPeriods(260)
                    ->setWagesInCents(1000)
                    ->setExpectedAmountInCents(11)
                    ->build()
            ],
            'case study 01' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setPayPeriods(260)
                    ->setWagesInCents(6668)
                    ->setExpectedAmountInCents(688)
                    ->build()
            ],
            'exempt true' => [
                $builder
                    ->setTaxInfoOptions([
                        'exempt' => true,
                    ])
                    ->setPayPeriods(24)
                    ->setWagesInCents(230000)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            'exempt false' => [
                $builder
                    ->setTaxInfoOptions([
                        'exempt' => false,
                    ])
                    ->setPayPeriods(24)
                    ->setWagesInCents(230000)
                    ->setExpectedAmountInCents(37348)
                    ->build()
            ],
        ];
    }

    public static function provideAdditionalWithholdingTestData(): array
    {
        $builder = new TestParametersBuilder();
        $builder
            ->setDate(self::DATE)
            ->setHomeLocation(self::LOCATION)
            ->setTaxClass(self::TAX_CLASS)
            ->setTaxInfoClass(self::TAX_INFO_CLASS)
            ->setPayPeriods(1);

        return [
            'additional withholding no wages' => [
                $builder
                    ->setTaxInfoOptions([
                        'additional_withholding' => 10,
                    ])
                    ->setWagesInCents(0)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            'additional withholding not enough wages 01' => [
                $builder
                    ->setTaxInfoOptions([
                        'additional_withholding' => 10,
                    ])
                    ->setWagesInCents(100)
                    ->setExpectedAmountInCents(92)
                    ->build()
            ],
            'additional withholding not enough wages 02' => [
                $builder
                    ->setTaxInfoOptions([
                        'additional_withholding' => 10,
                    ])
                    ->setWagesInCents(1000)
                    ->setExpectedAmountInCents(923)
                    ->build()
            ],
            'additional withholding single' => [
                $builder
                    ->setTaxInfoOptions([
                        'additional_withholding' => 10,
                    ])
                    ->setWagesInCents(230100)
                    ->setExpectedAmountInCents(1010)
                    ->build()
            ],
            'additional withholding married' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => FederalIncome::FILING_MARRIED,
                        'additional_withholding' => 20,
                    ])
                    ->setWagesInCents(865100)
                    ->setExpectedAmountInCents(2010)
                    ->build()
            ],
        ];
    }
}
