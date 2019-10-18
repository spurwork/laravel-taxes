<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Ohio\V20190101;

use Appleton\Taxes\Countries\US\Ohio\Dayton\Dayton;
use Appleton\Taxes\Tests\Unit\Countries\IncomeParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;
use Carbon\Carbon;

class DaytonTest extends TaxTestCase
{
    private const DATE = '2019-02-01';
    private const LOCATION = 'us.ohio.dayton';
    private const TAX_CLASS = Dayton::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);
    }

    /** @dataProvider dataProvider */
    public function testTax(?Carbon $birth_date, ?int $amount): void
    {
        $this->validate(
            (new IncomeParametersBuilder())
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
            'over 16' => [
                Carbon::now()->subYears(17),
                750
            ],
            'exactly 16' => [
                Carbon::now()->subYears(16),
                750
            ],
            'under 16' => [
                Carbon::now()->subYears(15),
                null
            ],
        ];
    }
}
