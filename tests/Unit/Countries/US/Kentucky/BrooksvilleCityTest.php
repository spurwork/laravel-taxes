<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\BrooksvilleCity\BrooksvilleCity;
use Carbon\Carbon;
use TestCase;

class BrooksvilleCityTest extends TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testBrooksvilleCity($date, $earnings, $ytd_earnings, $result)
    {
        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) use ($ytd_earnings, $earnings) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.brooksville_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.brooksville_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setYtdEarnings($ytd_earnings);
        });

        $this->assertSame($result, $results->getTax(BrooksvilleCity::class));
    }

    public function provideTestData()
    {
        return [
            '0' => [
                'January 1, 2019 8am',
                0,
                0,
                null,
            ],
            '1' => [
                'January 1, 2019 8am',
                300,
                5000,
                5.25,
            ],
            '2' => [
                'January 1, 2019 8am',
                900,
                50528.58,
                15.75,
            ],
            '3' => [
                'January 1, 2019 8am',
                771,
                51428.58,
                null,
            ],
        ];
    }
}
