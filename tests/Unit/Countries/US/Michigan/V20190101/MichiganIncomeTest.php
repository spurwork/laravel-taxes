<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Michigan\V20190101;

use Appleton\Taxes\Countries\US\Michigan\MichiganIncome\MichiganIncome;
use Appleton\Taxes\Models\Countries\US\Michigan\MichiganIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class MichiganIncomeTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.michigan';
    private const TAX_CLASS = MichiganIncome::class;
    private const TAX_INFO_CLASS = MichiganIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        MichiganIncomeTaxInformation::createForUser([
            'filing_status' => MichiganIncome::FILING_SINGLE,
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
            'one exemption' => [
                $builder
                    ->setTaxInfoOptions(['dependents' => 1])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(915)
                    ->build()
            ],
            'three exemption' => [
                $builder
                    ->setTaxInfoOptions(['dependents' => 3])
                    ->setWagesInCents(38462)
                    ->setExpectedAmountInCents(555)
                    ->build()
            ],
        ];
    }
}
