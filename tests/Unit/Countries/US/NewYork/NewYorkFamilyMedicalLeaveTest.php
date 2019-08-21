<?php

namespace Appleton\Taxes\Countries\US\NewYork\NewYorkFamilyMedicalLeave;

use Carbon\Carbon;

class NewYorkFamilyMedicalLeaveTest extends \TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testNewYorkFamilyMedicalLeave($date, $wtd_earnings, $earnings, $result)
    {
        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) use ($wtd_earnings, $earnings) {
            $taxes->setHomeLocation($this->getLocation('us.new_york'));
            $taxes->setWorkLocation($this->getLocation('us.new_york'));
            $taxes->setUser($this->user);
            $taxes->setWtdEarnings($wtd_earnings);
            $taxes->setEarnings($earnings);
        });

        $this->assertSame($result, $results->getTax(NewYorkFamilyMedicalLeave::class));
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
                0,
                350,
                0.54,
            ],
            '2' => [
                'January 1, 2019 8am',
                (function () {
                    return 0;
                }),
                1400,
                2.08,
            ],
        ];
    }
}
