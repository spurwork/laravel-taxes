<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Georgia\V20190101;

use Appleton\Taxes\Countries\US\Georgia\GeorgiaIncome\GeorgiaIncome;
use Appleton\Taxes\Models\Countries\US\Georgia\GeorgiaIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class GeorgiaIncomeTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.georgia';
    private const TAX_CLASS = GeorgiaIncome::class;
    private const TAX_INFO_CLASS = GeorgiaIncomeTaxInformation::class;
    
    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(GeorgiaIncome::class);

        GeorgiaIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'allowances' => 0,
            'dependents' => 0,
            'personal_allowances' => 0,
            'filing_status' => GeorgiaIncome::FILING_SINGLE,
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
            ->setPayPeriods(260);

        return [
            '01' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(6668)
                    ->setPayPeriods(260)
                    ->setExpectedAmountInCents(215)
                    ->build()
            ],
            '02' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(68000)
                    ->setPayPeriods(52)
                    ->setExpectedAmountInCents(3069)
                    ->build()
            ],
            'married with allowances' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => GeorgiaIncome::FILING_MARRIED_JOINT_BOTH_WORKING,
                        'allowances' => 1,
                        'personal_allowances' => 1,
                    ])
                    ->setWagesInCents(30000)
                    ->setPayPeriods(52)
                    ->setExpectedAmountInCents(430)
                    ->build()
            ],
            'joint with allowance' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => GeorgiaIncome::FILING_MARRIED_JOINT_ONE_WORKING,
                        'personal_allowances' => 1,
                    ])
                    ->setWagesInCents(30000)
                    ->setPayPeriods(52)
                    ->setExpectedAmountInCents(280)
                    ->build()
            ],
            'joint with allowances' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => GeorgiaIncome::FILING_MARRIED_JOINT_BOTH_WORKING,
                        'allowances' => 1,
                        'personal_allowances' => 2,
                    ])
                    ->setWagesInCents(30000)
                    ->setPayPeriods(52)
                    ->setExpectedAmountInCents(88)
                    ->build()
            ],
        ];
    }
}
