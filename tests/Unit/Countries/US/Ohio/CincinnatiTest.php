<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Cincinnati\Cincinnati;
use Carbon\Carbon;
use TestCase;

class CincinnatiTest extends TestCase
{
    /** @dataProvider dataProvider */
    public function testCincinnati(?Carbon $birth_date, ?float $amount): void
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) use ($birth_date) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.cincinnati'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.cincinnati'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
            $taxes->setBirthDate($birth_date);
        });

        $this->assertSame($amount, $results->getTax(Cincinnati::class));
    }

    public function dataProvider(): array
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        return [
            'no birth date' => [
                null,
                6.30
            ],
            'over 18' => [
                Carbon::now()->subYears(19),
                6.30
            ],
            'exactly 18' => [
                Carbon::now()->subYears(18),
                6.30
            ],
            'under 18' => [
                Carbon::now()->subYears(17),
                null
            ],
        ];
    }
}
