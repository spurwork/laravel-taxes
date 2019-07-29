<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\CampbellCounty\CampbellCounty;
use Carbon\Carbon;
use TestCase;

class CampbellCountyTest extends TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testCampbellCounty($date, $earnings, $ytd_earnings, $result)
    {
        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) use ($ytd_earnings, $earnings) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.campbell_county'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.campbell_county'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setYtdEarnings($ytd_earnings);
        });

        $this->assertSame($result, $results->getTax(CampbellCounty::class));
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
                3.15,
            ],
            '2' => [
                'January 1, 2019 8am',
                900,
                36600,
                9.45,
            ],
            '3' => [
                'January 1, 2019 8am',
                771,
                38667,
                null,
            ],
        ];
    }
}
