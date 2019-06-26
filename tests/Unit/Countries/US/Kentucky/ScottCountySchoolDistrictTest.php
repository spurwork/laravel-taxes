<?php

namespace Appleton\Taxes\Countries\US\Kentucky\ScottCountySchoolDistrict;

use Appleton\Taxes\Countries\US\Kentucky\ScottCountySchoolDistrict\ScottCountySchoolDistrict;
use Appleton\Taxes\Models\Countries\US\Kentucky\KentuckyIncomeTaxInformation;
use Carbon\Carbon;

class ScottCountySchoolDistrictTest extends \TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testScottCountySchoolDistrict($date, $home_location, $work_location, $earnings, $lives_in_scsd, $result)
    {
        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        KentuckyIncomeTaxInformation::forUser($this->user)->update([
            'lives_in_scsd' => $lives_in_scsd
        ]);

        $results = $this->taxes->calculate(function ($taxes) use ($home_location, $work_location, $earnings) {
            $taxes->setHomeLocation($home_location);
            $taxes->setWorkLocation($work_location);
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame($result, $results->getTax(ScottCountySchoolDistrict::class));
    }

    public function provideTestData()
    {
        return [
            '0' => [
                'January 1, 2019 8am',
                $this->getLocation('us.kentucky.scott_county'),
                $this->getLocation('us.kentucky.scott_county'),
                300,
                true,
                1.5,
            ],
            '1' => [
                'January 1, 2019 8am',
                $this->getLocation('us.kentucky.scott_county'),
                $this->getLocation('us.kentucky.scott_county'),
                300,
                false,
                0.0,
            ],
        ];
    }
}
