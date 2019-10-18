<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Arizona\V20180101;

use Appleton\Taxes\Countries\US\Arizona\ArizonaIncome\ArizonaIncome;
use Appleton\Taxes\Models\Countries\US\Arizona\ArizonaIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\IncomeParameters;
use Appleton\Taxes\Tests\Unit\Countries\IncomeParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class ArizonaIncomeTest extends TaxTestCase
{
    private const DATE = '2018-01-01';
    private const LOCATION = 'us.arizona';
    private const TAX_CLASS = ArizonaIncome::class;
    private const TAX_INFO_CLASS = ArizonaIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        ArizonaIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'percentage_withheld' => 2.7,
            'exempt' => 0,
        ], $this->user);
    }

    /**
     * @dataProvider provideTestData
     */
    public function testTax(IncomeParameters $parameters): void
    {
        $this->validate($parameters);
    }

    public function provideTestData(): array
    {
        $builder = new IncomeParametersBuilder();
        $builder
            ->setDate(self::DATE)
            ->setHomeLocation(self::LOCATION)
            ->setTaxClass(self::TAX_CLASS)
            ->setTaxInfoClass(self::TAX_INFO_CLASS)
            ->setPayPeriods(52);

        return [
            '01' => [
                $builder
                    ->setTaxInfoOptions(['percentage_withheld' => 1.3])
                    ->setWagesInCents(10000)
                    ->setExpectedAmountInCents(130)
                    ->build()
            ],
            '02' => [
                $builder
                    ->setTaxInfoOptions(['percentage_withheld' => 4.2])
                    ->setWagesInCents(10000)
                    ->setExpectedAmountInCents(420)
                    ->build()
            ],
        ];
    }
}
