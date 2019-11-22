<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Vermont\V20190101;

use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome;
use Appleton\Taxes\Countries\US\Vermont\VermontIncome\VermontIncome;
use Appleton\Taxes\Models\Countries\US\FederalIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\Vermont\VermontIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class VermontIncomeTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.vermont';
    private const TAX_CLASS = VermontIncome::class;
    private const TAX_INFO_CLASS = VermontIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(FederalIncome::class);
        $this->query_runner->addTax(self::TAX_CLASS);

        FederalIncomeTaxInformation::createForUser([
            'filing_status' => FederalIncome::FILING_SINGLE,
            'exemptions' => 0,
            'additional_withholding' => 0,
            'non_resident_alien' => false,
            'exempt' => false,
        ], $this->user);

        VermontIncomeTaxInformation::createForUser([
            'filing_status' => VermontIncome::FILING_SINGLE,
            'allowances' => 0,
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

    public function testTax_federal_additional_withholding(): void
    {
        FederalIncomeTaxInformation::forUser($this->user)->update([
            'additional_withholding' => 10,
        ]);

        $this->validate(
            (new TestParametersBuilder())
                ->setDate(self::DATE)
                ->setHomeLocation(self::LOCATION)
                ->setTaxClass(self::TAX_CLASS)
                ->setTaxInfoClass(self::TAX_INFO_CLASS)
                ->setPayPeriods(52)
                ->setTaxInfoOptions(['additional_withholding' => 10])
                ->setWagesInCents(30000)
                ->setExpectedAmountInCents(2106)
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
            'test case 2' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(30000)
                    ->setSupplementalWagesInCents(0)
                    ->setExpectedAmountInCents(806)
                    ->build()
            ],
            'test case 3' => [
                $builder
                    ->setTaxInfoOptions(['allowances' => 2])
                    ->setWagesInCents(100000)
                    ->setSupplementalWagesInCents(0)
                    ->setExpectedAmountInCents(2655)
                    ->build()
            ],
            'test case 4' => [
                $builder
                    ->setTaxInfoOptions(['allowances' => 2])
                    ->setWagesInCents(250000)
                    ->setSupplementalWagesInCents(0)
                    ->setExpectedAmountInCents(12987)
                    ->build()
            ],
            'test case 6' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => VermontIncome::FILING_MARRIED_FILING_JOINTLY,
                        'allowances' => 2,
                    ])
                    ->setWagesInCents(100000)
                    ->setSupplementalWagesInCents(0)
                    ->setExpectedAmountInCents(2208)
                    ->build()
            ],
            'test case 7' => [
                $builder
                    ->setTaxInfoOptions(['filing_status' => VermontIncome::FILING_MARRIED_FILING_JOINTLY])
                    ->setWagesInCents(200000)
                    ->setSupplementalWagesInCents(0)
                    ->setExpectedAmountInCents(7894)
                    ->build()
            ],
            'test case 8' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => VermontIncome::FILING_MARRIED_FILING_JOINTLY,
                        'allowances' => 2,
                    ])
                    ->setWagesInCents(200000)
                    ->setSupplementalWagesInCents(0)
                    ->setExpectedAmountInCents(6815)
                    ->build()
            ],
            'test case 9' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(5000)
                    ->setSupplementalWagesInCents(0)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            'additional withholding' => [
                $builder
                    ->setTaxInfoOptions(['additional_withholding' => 10])
                    ->setWagesInCents(30000)
                    ->setSupplementalWagesInCents(0)
                    ->setExpectedAmountInCents(1806)
                    ->build()
            ],
            'supplemental earnings' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(30000)
                    ->setSupplementalWagesInCents(1000)
                    ->setExpectedAmountInCents(779)
                    ->build()
            ],
            'exempt' => [
                $builder
                    ->setTaxInfoOptions(['exempt' => true])
                    ->setWagesInCents(30000)
                    ->setSupplementalWagesInCents(0)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
        ];
    }
}
