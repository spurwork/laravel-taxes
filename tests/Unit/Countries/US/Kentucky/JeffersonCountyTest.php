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
    public function testJeffersonCounty($date, $home_location, $work_location, $earnings, $exempt, $result)
    {
        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        if ($exempt) {
            KentuckyIncomeTaxInformation::forUser($this->user)
                ->update([
                    'exempt' => true,
                ]);
        }

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
        // home location
        // work location
        // earnings
        // exempt
        // result
        return [
            // Live and work in Jefferson County
            '0' => [
                'January 1, 2019 8am',
                $this->getLocation('us.kentucky.jefferson_county'),
                $this->getLocation('us.kentucky.jefferson_county'),
                300,
                false,
                6.60,
            ],
            // Work in Kentucky live in Jefferson county in state
            '1' => [
                'January 1, 2019 8am',
                $this->getLocation('us.kentucky'),
                $this->getLocation('us.kentucky.jefferson_county'),
                300,
                false,
                4.35,
            ],
            // non-resident out of state
            '2' => [
                'January 1, 2019 8am',
                $this->getLocation('us.alabama'),
                $this->getLocation('us.kentucky.jefferson_county'),
                300,
                false,
                4.35,
            ],
            // Live and work in Jefferson County - exempt
            '3' => [
                'January 1, 2019 8am',
                $this->getLocation('us.kentucky.jefferson_county'),
                $this->getLocation('us.kentucky.jefferson_county'),
                300,
                true,
                null,
            ],
            // Live in Kentucky work in Jefferson County - exempt
            '4' => [
                'January 1, 2019 8am',
                $this->getLocation('us.kentucky'),
                $this->getLocation('us.kentucky.jefferson_county'),
                300,
                true,
                null,
            ],
            // Live in Alabama work in Jefferson County Kentucky - exempt
            '5' => [
                'January 1, 2019 8am',
                $this->getLocation('us.alabama'),
                $this->getLocation('us.kentucky.jefferson_county'),
                300,
                true,
                null,
            ],
            // live in Jefferson county work in Kentucky. Should be null
            '6' => [
                'January 1, 2019 8am',
                $this->getLocation('us.kentucky.jefferson_county'),
                $this->getLocation('us.kentucky'),
                300,
                false,
                null,
            ],
            // live in Kentucky work in Kentucky. Should be null
            '7' => [
                'January 1, 2019 8am',
                $this->getLocation('us.kentucky'),
                $this->getLocation('us.kentucky'),
                300,
                false,
                null,
            ],
        ];
    }
}
