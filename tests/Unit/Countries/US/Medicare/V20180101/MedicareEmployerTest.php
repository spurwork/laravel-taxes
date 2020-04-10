<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Medicare\V20180101;

use Appleton\Taxes\Countries\US\Medicare\MedicareEmployer;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;

class MedicareEmployerTest extends TaxTestCase
{
    private const DATE = '2018-01-01';
    private const LOCATION = 'us.alabama';
    private const TAX_CLASS = MedicareEmployer::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);
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
            ->setPayPeriods(1);

        return [
            'case study A' => [
                $builder
                    ->setWagesInCents(27167)
                    ->setYtdLiabilitiesInCents(2489733)
                    ->setExpectedAmountInCents(394)
                    ->build()
            ],
            'case study B' => [
                $builder
                    ->setWagesInCents(76512)
                    ->setYtdLiabilitiesInCents(20010000)
                    ->setExpectedAmountInCents(1109)
                    ->build()
            ],
        ];
    }

}
