<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\CamargoCity\CamargoCity;
use Carbon\Carbon;
use TestCase;

class CamargoCityTest extends TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testCamargoCity(string $date, int $earnings, float $result)
    {
        Carbon::setTestNow(Carbon::parse($date));

        $results = $this->taxes->calculate(function ($taxes) use ($earnings) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.camargo_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.camargo_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame($result, $results->getTax(CamargoCity::class));
    }

    public function provideTestData(): array
    {
        // [$date, $earnings, $result]
        return [
            '2019-01-01' => ['2019-01-01', 300, 3.0],
            '2019-07-01' => ['2019-07-01', 300, 6.0],
        ];
    }
}
