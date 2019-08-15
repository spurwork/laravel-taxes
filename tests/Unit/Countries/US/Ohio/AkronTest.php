<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Akron\Akron;
use Carbon\Carbon;
use TestCase;

class AkronTest extends TestCase
{
    /** @dataProvider dataProvider */
    public function testAkron(?Carbon $birth_date, ?float $amount): void
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) use ($birth_date) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.akron'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.akron'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
            $taxes->setBirthDate($birth_date);
        });

        $this->assertSame($amount, $results->getTax(Akron::class));
    }

    public function dataProvider(): array
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        return [
            'no birth date' => [
                null,
                7.50
            ],
            'over 18' => [
                Carbon::now()->subYears(19),
                7.50
            ],
            'exactly 18' => [
                Carbon::now()->subYears(18),
                7.50
            ],
            '18 by then end of the year' => [
                Carbon::now()->subYears(18)->addMonths(1),
                7.50
            ],
            'under 18' => [
                Carbon::now()->subYears(17),
                null
            ],
        ];
    }
}
