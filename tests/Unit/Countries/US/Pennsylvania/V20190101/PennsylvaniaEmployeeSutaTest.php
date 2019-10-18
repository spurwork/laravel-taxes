<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Pennsylvania\V20190101;

use Appleton\Taxes\Countries\US\Pennsylvania\PennsylvaniaEmployeeSuta\PennsylvaniaEmployeeSuta;
use Appleton\Taxes\Tests\Unit\Countries\IncomeParameters;
use Appleton\Taxes\Tests\Unit\Countries\IncomeParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class PennsylvaniaEmployeeSutaTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.pennsylvania';
    private const TAX_CLASS = PennsylvaniaEmployeeSuta::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);
    }

    /**
     * @dataProvider provideData
     */
    public function testWageBase(IncomeParameters $parameters): void
    {
        $this->validate($parameters);
    }

    public function provideData(): array
    {
        $builder = new IncomeParametersBuilder();
        $builder
            ->setDate(self::DATE)
            ->setHomeLocation(self::LOCATION)
            ->setTaxClass(self::TAX_CLASS)
            ->setPayPeriods(52);

        return [
            '00' => [
                $builder
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(18)
                    ->build()
            ],
            '01' => [
                $builder
                    ->setWagesInCents(10000)
                    ->setExpectedAmountInCents(6)
                    ->build()
            ],
            '02' => [
                $builder
                    ->setWagesInCents(200000)
                    ->setExpectedAmountInCents(120)
                    ->build()
            ],
        ];
    }
}
