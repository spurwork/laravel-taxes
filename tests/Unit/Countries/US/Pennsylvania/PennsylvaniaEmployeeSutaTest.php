<?php

namespace Appleton\Taxes\Unit\Countries\US\Pennsylvania\PennsylvaniaEmployeeSuta;

use Appleton\Taxes\Countries\US\Pennsylvania\PennsylvaniaEmployeeSuta\PennsylvaniaEmployeeSuta;
use Carbon\Carbon;
use TestCase;

class PennsylvaniaEmployeeSutaTest extends TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testPennsylvaniaEmployeeSuta($date, $earnings, $result)
    {
        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) use ($earnings) {
            $taxes->setHomeLocation($this->getLocation('us.alabama'));
            $taxes->setWorkLocation($this->getLocation('us.alabama'));
            $taxes->setSutaLocation($this->getLocation('us.pennsylvania'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame($result, $results->getTax(PennsylvaniaEmployeeSuta::class));
    }

    public function provideTestData()
    {
        // date
        // earnings
        // results
        return [
            '0' => [
                'January 1, 2019 8am',
                300,
                0.18,
            ],
            '1' => [
                'January 1, 2019 8am',
                100,
                0.06,
            ],
            '2' => [
                'January 1, 2019 8am',
                2000,
                1.2,
            ],
        ];
    }
}
