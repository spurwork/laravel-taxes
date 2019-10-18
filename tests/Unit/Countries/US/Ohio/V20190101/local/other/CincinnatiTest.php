<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Ohio\V20190101;

use Appleton\Taxes\Countries\US\Ohio\Cincinnati\Cincinnati;
use Appleton\Taxes\Tests\Unit\Countries\IncomeParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;
use Carbon\Carbon;

class CincinnatiTest extends TaxTestCase
{
    private const DATE = '2019-02-01';
    private const LOCATION = 'us.ohio.cincinnati';
    private const TAX_CLASS = Cincinnati::class;

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
                630
            ],
            'over 18' => [
                Carbon::now()->subYears(19),
                630
            ],
            'exactly 18' => [
                Carbon::now()->subYears(18),
                630
            ],
            'under 18' => [
                Carbon::now()->subYears(17),
                null
            ],
        ];
    }
}
