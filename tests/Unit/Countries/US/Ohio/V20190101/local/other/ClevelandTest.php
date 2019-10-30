<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Ohio\V20190101;

use Appleton\Taxes\Countries\US\Ohio\Cleveland\Cleveland;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;
use Carbon\Carbon;

class ClevelandTest extends TaxTestCase
{
    private const DATE = '2019-02-01';
    private const LOCATION = 'us.ohio.cleveland';
    private const TAX_CLASS = Cleveland::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);
    }

    /** @dataProvider dataProvider */
    public function testTax(?Carbon $birth_date, ?int $amount): void
    {
        $this->validate(
            (new TestParametersBuilder())
                ->setDate(self::DATE)
                ->setBirthDate($birth_date)
                ->setHomeLocation(self::LOCATION)
                ->setTaxClass(self::TAX_CLASS)
                ->setPayPeriods(52)
                ->setWagesInCents(30000)
                ->setExpectedAmountInCents($amount)
                ->build()
        );
    }

    public function dataProvider(): array
    {
        Carbon::setTestNow(Carbon::parse(self::DATE));

        return [
            'no birth date' => [
                null,
                750
            ],
            'over 18' => [
                Carbon::now()->subYears(19),
                750
            ],
            'exactly 18' => [
                Carbon::now()->subYears(18),
                750
            ],
            'under 18' => [
                Carbon::now()->subYears(17),
                null
            ],
        ];
    }
}
