<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Alabama\V20170101;

use Appleton\Taxes\Countries\US\Alabama\AlabamaIncome\AlabamaIncome;
use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome;
use Appleton\Taxes\Countries\US\Medicare\Medicare;
use Appleton\Taxes\Countries\US\SocialSecurity\SocialSecurity;
use Appleton\Taxes\Models\Countries\US\Alabama\AlabamaIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\FederalIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class AlabamaIncomeTest extends TaxTestCase
{
    private const DATE = '2017-01-01';
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
        $this->query_runner->addTax(SocialSecurity::class);
        $this->query_runner->addTax(Medicare::class);

        $this->validate($parameters);
    }

    /**
     * @dataProvider provideUseDefaultTestData
     */
    public function testTax_use_default(TestParameters $parameters): void
    {
        AlabamaIncomeTaxInformation::forUser($this->user)->delete();

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
            ->setPayPeriods(260);

        return [
            '01' => [
                $builder
                    ->setWagesInCents(6668)
                    ->setExpectedAmountInCents(206)
                    ->build()
            ],
            'supplemental' => [
                (new TestParametersBuilder())
                    ->setDate(self::DATE)
                    ->setHomeLocation(self::LOCATION)
                    ->setTaxClass(self::TAX_CLASS)
                    ->setWagesInCents(10000)
                    ->setSupplementalWagesInCents(10000)
                    ->setPayPeriods(1)
                    ->setExpectedAmountInCents(500)
                    ->build()
            ],
            'non-negative' => [
                $builder
                    ->setWagesInCents(1000)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            'no exemptions' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => AlabamaIncome::FILING_ZERO,
                    ])
                    ->setWagesInCents(6668)
                    ->setExpectedAmountInCents(283)
                    ->build()
            ],
            'exempt true' => [
                $builder
                    ->setTaxInfoOptions([
                        'exempt' => true,
                    ])
                    ->setWagesInCents(6668)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            'exempt false' => [
                $builder
                    ->setTaxInfoOptions([
                        'exempt' => false,
                    ])
                    ->setWagesInCents(6668)
                    ->setExpectedAmountInCents(206)
                    ->build()
            ],
        ];
    }

    public function provideAdditionalWithholdingTestData(): array
    {
        $builder = new TestParametersBuilder();
        $builder
            ->setDate(self::DATE)
            ->setHomeLocation(self::LOCATION)
            ->setTaxClass(self::TAX_CLASS)
            ->setTaxInfoClass(self::TAX_INFO_CLASS)
            ->setTaxInfoOptions([
                'additional_withholding' => 10
            ])
            ->setPayPeriods(260);

        return [
            'additional withholding no earnings' => [
                $builder
                    ->setWagesInCents(0)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            'additional withholding 02' => [
                $builder
                    ->setWagesInCents(100)
                    ->setExpectedAmountInCents(92)
                    ->build()
            ],
            'additional withholding 03' => [
                $builder
                    ->setTaxInfoOptions([
                        'additional_withholding' => 10
                    ])
                    ->setWagesInCents(1000)
                    ->setExpectedAmountInCents(911)
                    ->build()
            ],
            'additional withholding 04' => [
                $builder
                    ->setWagesInCents(6668)
                    ->setExpectedAmountInCents(1206)
                    ->build()
            ],
        ];
    }

    public function provideUseDefaultTestData(): array
    {
        return [
            'default tax information' => [
                (new TestParametersBuilder())
                    ->setDate(self::DATE)
                    ->setHomeLocation(self::LOCATION)
                    ->setTaxClass(self::TAX_CLASS)
                    ->setTaxInfoClass(self::TAX_INFO_CLASS)
                    ->setWagesInCents(6668)
                    ->setPayPeriods(260)
                    ->setExpectedAmountInCents(206)
                    ->build()
            ],
        ];
    }
}
