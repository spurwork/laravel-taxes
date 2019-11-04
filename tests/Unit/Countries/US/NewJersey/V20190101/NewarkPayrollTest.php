<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\NewJersey\V20190101;

use Appleton\Taxes\Countries\US\NewJersey\NewarkPayroll\NewarkPayroll;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class NewarkPayrollTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.new_jersey.newark';
    private const TAX_CLASS = NewarkPayroll::class;

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
            ->setPayPeriods(52);

        return [
            '01' => [
                $builder
                    ->setWagesInCents(74500)
                    ->setExpectedAmountInCents(745)
                    ->build()
            ],
        ];
    }
}
