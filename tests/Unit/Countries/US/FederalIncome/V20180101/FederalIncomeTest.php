<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\FederalIncome\V20180101;

use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome;
use Appleton\Taxes\Models\Countries\US\FederalIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class FederalIncomeTest extends TaxTestCase
{
    private const DATE = '2018-01-01';
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
     * @dataProvider provideUseDefaultTestData
     */
    public function testTax_use_default(TestParameters $parameters): void
    {
        FederalIncomeTaxInformation::forUser($this->user)->delete();

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
            'A' => [
                $builder
                    ->setTaxInfoOptions([
                        'exemptions' => 1,
                    ])
                    ->setWagesInCents(25869)
                    ->setExpectedAmountInCents(1077)
                    ->build()
            ],
            'B' => [
                $builder
                    ->setTaxInfoOptions([
                        'exemptions' => 4,
                        'filing_status' => FederalIncome::FILING_MARRIED,
                    ])
                    ->setWagesInCents(47525)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            'C' => [
                $builder
                    ->setTaxInfoOptions([
                        'exemptions' => 2,
                    ])
                    ->setWagesInCents(11233)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            'D' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(86514)
                    ->setExpectedAmountInCents(9659)
                    ->build()
            ],
            'E' => [
                $builder
                    ->setTaxInfoOptions([
                        'exemptions' => 3,
                        'filing_status' => FederalIncome::FILING_MARRIED,
                    ])
                    ->setWagesInCents(36757)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            'H' => [
                $builder
                    ->setTaxInfoOptions([
                        'exemptions' => 2,
                    ])
                    ->setWagesInCents(80000)
                    ->setExpectedAmountInCents(6464)
                    ->build()
            ],
        ];
    }

    public function provideUseDefaultTestData(): array
    {
        return [
            '01' => [
                (new TestParametersBuilder())
                    ->setDate(self::DATE)
                    ->setHomeLocation(self::LOCATION)
                    ->setTaxClass(self::TAX_CLASS)
                    ->setTaxInfoClass(self::TAX_INFO_CLASS)
                    ->setWagesInCents(80000)
                    ->setPayPeriods(52)
                    ->setExpectedAmountInCents(8379)
                    ->build()
            ],
        ];
    }
}
