<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Massachusetts\V20190101;

use Appleton\Taxes\Countries\US\Massachusetts\MassachusettsIncome\MassachusettsIncome;
use Appleton\Taxes\Countries\US\Medicare\Medicare;
use Appleton\Taxes\Countries\US\SocialSecurity\SocialSecurity;
use Appleton\Taxes\Models\Countries\US\Massachusetts\MassachusettsIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class MassachusettsIncomeTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.massachusetts';
    private const TAX_CLASS = MassachusettsIncome::class;
    private const TAX_INFO_CLASS = MassachusettsIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(Medicare::class);
        $this->query_runner->addTax(SocialSecurity::class);
        $this->query_runner->addTax(self::TAX_CLASS);

        MassachusettsIncomeTaxInformation::createForUser([
            'filing_status' => MassachusettsIncome::FILING_SINGLE,
            'exemptions' => 0,
            'blind' => 0,
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
                    ->setWagesInCents(12500)
                    ->setExpectedAmountInCents(582)
                    ->build()
            ],
            '01' => [
                $builder
                    ->setTaxInfoOptions(['exemptions' => 1])
                    ->setWagesInCents(12500)
                    ->setExpectedAmountInCents(null)
                    ->build()
            ],
            '02' => [
                $builder
                    ->setTaxInfoOptions(['filing_status' => MassachusettsIncome::FILING_HEAD_OF_HOUSEHOLD])
                    ->setWagesInCents(12500)
                    ->setExpectedAmountInCents(349)
                    ->build()
            ],
            '03' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => MassachusettsIncome::FILING_HEAD_OF_HOUSEHOLD,
                        'exemptions' => 1,
                    ])
                    ->setWagesInCents(12500)
                    ->setExpectedAmountInCents(null)
                    ->build()
            ],
            '04' => [
                $builder
                    ->setTaxInfoOptions(['blind' => 1])
                    ->setWagesInCents(12500)
                    ->setExpectedAmountInCents(369)
                    ->build()
            ],
            '05' => [
                $builder
                    ->setTaxInfoOptions(['blind' => 2])
                    ->setWagesInCents(12500)
                    ->setExpectedAmountInCents(155)
                    ->build()
            ],
            '06' => [
                $builder
                    ->setTaxInfoOptions(['exemptions' => 1])
                    ->setWagesInCents(50000)
                    ->setExpectedAmountInCents(1904)
                    ->build()
            ],
            '07' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => MassachusettsIncome::FILING_HEAD_OF_HOUSEHOLD,
                        'exemptions' => 2,
                    ])
                    ->setWagesInCents(50000)
                    ->setExpectedAmountInCents(1574)
                    ->build()
            ],
            '08' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => MassachusettsIncome::FILING_HEAD_OF_HOUSEHOLD,
                        'exemptions' => 2,
                        'blind' => 2,
                    ])
                    ->setWagesInCents(50000)
                    ->setExpectedAmountInCents(1147)
                    ->build()
            ],
        ];
    }
}
