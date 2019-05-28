<?php

namespace Appleton\Taxes\Countries\US\Kentucky\JeffersonCounty;

use Appleton\Taxes\Countries\US\Kentucky\JeffersonCounty\JeffersonCounty;
use Appleton\Taxes\Models\Countries\US\Kentucky\KentuckyIncomeTaxInformation;
use Carbon\Carbon;

class JeffersonCountyTest extends \TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testJeffersonCounty($date, $home_location, $work_location, $earnings, $result)
    {
        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        // KentuckyIncomeTaxInformation::forUser($this->user)
        //     ->update([
        //         'exempt' => true,
        //     ]);

        $results = $this->taxes->calculate(function ($taxes) use ($home_location, $work_location, $earnings) {
            $taxes->setHomeLocation($home_location);
            $taxes->setWorkLocation($work_location);
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame($result, $results->getTax(JeffersonCounty::class));
    }

    public function provideTestData()
    {
        return [
            // resident
            '0' => [
                'January 1, 2019 8am',
                $this->getLocation('us.kentucky.jefferson_county'),
                $this->getLocation('us.kentucky.jefferson_county'),
                300,
                6.60,
            ],
            // non-resident in state
            '1' => [
                'January 1, 2019 8am',
                $this->getLocation('us.kentucky'),
                $this->getLocation('us.kentucky.jefferson_county'),
                300,
                4.35,
            ],
            // non-resident out of state
            '2' => [
                'January 1, 2019 8am',
                $this->getLocation('us.alabama'),
                $this->getLocation('us.kentucky.jefferson_county'),
                300,
                4.35,
            ],
        ];
    }
}
