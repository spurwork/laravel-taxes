<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\SocialSecurity\V20170101;

use Appleton\Taxes\Countries\US\SocialSecurity\SocialSecurityEmployer;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class SocialSecurityEmployerTest extends TaxTestCase
{
    private const DATE = '2017-01-01';
    private const LOCATION = 'us.alabama';
    private const TAX_CLASS = SocialSecurityEmployer::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);
    }

    /**
     * @dataProvider provideData
     */
    public function testWageBase(TestParameters $parameters): void
    {
        $this->validate($parameters);
    }

    public function provideData(): array
    {
        $builder = new TestParametersBuilder();
        $builder
            ->setDate(self::DATE)
            ->setHomeLocation(self::LOCATION)
            ->setTaxClass(self::TAX_CLASS)
            ->setPayPeriods(52);

        return [
            '00' => [
                $builder
                    ->setWagesInCents(230000)
                    ->setExpectedAmountInCents(14260)
                    ->build()
            ],
        ];
    }
}
