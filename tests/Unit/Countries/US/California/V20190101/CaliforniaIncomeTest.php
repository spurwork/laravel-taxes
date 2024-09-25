<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\California\V20190101;

use Appleton\Taxes\Countries\US\California\CaliforniaIncome\CaliforniaIncome;
use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome;
use Appleton\Taxes\Models\Countries\US\California\CaliforniaIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\FederalIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;

class CaliforniaIncomeTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.california';
    private const TAX_CLASS = CaliforniaIncome::class;
    private const TAX_INFO_CLASS = CaliforniaIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);
        $this->query_runner->addTax(FederalIncome::class);

        FederalIncomeTaxInformation::createForUser([
            'filing_status' => FederalIncome::FILING_SINGLE,
            'exemptions' => 0,
            'additional_withholding' => 0,
            'non_resident_alien' => false,
        ], $this->user);

        CaliforniaIncomeTaxInformation::createForUser([
            'filing_status' => CaliforniaIncome::FILING_SINGLE,
            'allowances' => 0,
            'estimated_deductions' => 0,
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

    public function testTax_cannot_determine_filing_status(): void
    {
        FederalIncomeTaxInformation::forUser($this->user)->update([
            'filing_status' => FederalIncome::FILING_SEPERATE,
        ]);

        $this->validate(
            (new TestParametersBuilder())
                ->setDate(self::DATE)
                ->setHomeLocation(self::LOCATION)
                ->setTaxClass(self::TAX_CLASS)
                ->setTaxInfoClass(self::TAX_INFO_CLASS)
                ->setPayPeriods(52)
                ->setTaxInfoOptions([
                    'filing_status' => null,
                ])
                ->setWagesInCents(100000)
                ->setExpectedAmountInCents(3787)
                ->build()
        );
    }

    public function testTax_use_federal_exemptions(): void
    {
        FederalIncomeTaxInformation::forUser($this->user)->update([
            'exemptions' => 1,
        ]);

        $this->validate(
            (new TestParametersBuilder())
                ->setDate(self::DATE)
                ->setHomeLocation(self::LOCATION)
                ->setTaxClass(self::TAX_CLASS)
                ->setTaxInfoClass(self::TAX_INFO_CLASS)
                ->setPayPeriods(52)
                ->setTaxInfoOptions([
                    'allowances' => null,
                ])
                ->setWagesInCents(100000)
                ->setExpectedAmountInCents(3537)
                ->build()
        );
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
            'test case 01' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(28025)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            'test case 02' => [
                $builder
                    ->setTaxInfoOptions([
                        'allowances' => 1,
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(43)
                    ->build()
            ],
            'test case 04' => [
                $builder
                    ->setTaxInfoOptions([
                        'allowances' => 2,
                    ])
                    ->setWagesInCents(70000)
                    ->setExpectedAmountInCents(1171)
                    ->build()
            ],
            'test case 05' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => CaliforniaIncome::FILING_MARRIED,
                    ])
                    ->setWagesInCents(28025)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            'test case 06' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => CaliforniaIncome::FILING_MARRIED,
                        'allowances' => 2,
                    ])
                    ->setWagesInCents(56050)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            'test case 07' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => CaliforniaIncome::FILING_MARRIED,
                        'allowances' => 2,
                    ])
                    ->setWagesInCents(60000)
                    ->setExpectedAmountInCents(86)
                    ->build()
            ],
            'test case 08' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => CaliforniaIncome::FILING_MARRIED,
                        'allowances' => 2,
                        'estimated_deductions' => 1,
                    ])
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(996)
                    ->build()
            ],
            'test case 09' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => CaliforniaIncome::FILING_HEAD_OF_HOUSEHOLD,
                    ])
                    ->setWagesInCents(56050)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            'test case 10' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => CaliforniaIncome::FILING_HEAD_OF_HOUSEHOLD,
                        'allowances' => 3,
                    ])
                    ->setWagesInCents(89900)
                    ->setExpectedAmountInCents(494)
                    ->build()
            ],
            'use federal filing status' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => null,
                    ])
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(3787)
                    ->build()
            ],
            'not enough wages' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => 'M',
                        'allowances' => 8,
                        'estimated_deductions' => 8,
                    ])
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
        ];
    }
}
