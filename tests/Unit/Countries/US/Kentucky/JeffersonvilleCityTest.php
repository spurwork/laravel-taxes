<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\JeffersonvilleCity\JeffersonvilleCity;
use Carbon\Carbon;
use TestCase;

class JeffersonvilleCityTest extends TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testJeffersonvilleCity(string $date, int $earnings, float $result)
    {
        Carbon::setTestNow(Carbon::parse($date));

        $results = $this->taxes->calculate(function ($taxes) use ($earnings) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.jeffersonville_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.jeffersonville_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame($result, $results->getTax(JeffersonvilleCity::class));
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
