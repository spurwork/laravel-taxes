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
    public function testJeffersonCounty($date, $home_location, $work_location, $additional_withholding, $exemptions, $earnings, $result)
    {
        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        KentuckyIncomeTaxInformation::forUser($this->user)
            ->update([
                'exemptions' => $exemptions,
                'additional_withholding' => $additional_withholding,
            ]);

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
                0,
                4,
                300,
                6.60,
            ],
            // non-resident
            '1' => [
                'January 1, 2019 8am',
                $this->getLocation('us.kentucky'),
                $this->getLocation('us.kentucky.jefferson_county'),
                0,
                4,
                300,
                4.35,
            ],
            // '2' => [
            //     'January 1, 2019 8am',
            //     $this->getLocation('us.kentucky.jefferson_county'),
            //     $this->getLocation('us.kentucky.jefferson_county'),
            //     0,
            //     12,
            //     500,
            //     0.85,
            // ],
            // '3' => [
            //     'January 1, 2019 8am',
            //     $this->getLocation('us.kentucky.jefferson_county'),
            //     $this->getLocation('us.kentucky.jefferson_county'),
            //     JeffersonCounty::FILING_MARRIED,
            //     3,
            //     700,
            //     4.17,
            // ],
            // '4' => [
            //     'January 1, 2019 8am',
            //     $this->getLocation('us.kentucky.jefferson_county'),
            //     $this->getLocation('us.kentucky.jefferson_county'),
            //     JeffersonCounty::FILING_MARRIED,
            //     5,
            //     900,
            //     5.85,
            // ],
            // '5' => [
            //     'January 1, 2019 8am',
            //     $this->getLocation('us.kentucky.jefferson_county'),
            //     $this->getLocation('us.kentucky.jefferson_county'),
            //     JeffersonCounty::FILING_MARRIED,
            //     2,
            //     2000,
            //     18.01,
            // ],
            // '6' => [
            //     'January 1, 2019 8am',
            //     $this->getLocation('us.kentucky.jefferson_county'),
            //     $this->getLocation('us.kentucky.jefferson_county'),
            //     JeffersonCounty::FILING_MARRIED,
            //     11,
            //     1000,
            //     5.69,
            // ],
            // '7' => [
            //     'January 1, 2019 8am',
            //     $this->getLocation('us.alabama'),
            //     $this->getLocation('us.kentucky.jefferson_county'),
            //     0,
            //     0,
            //     50,
            //     0.0,
            // ],
            // '8' => [
            //     'January 1, 2019 8am',
            //     $this->getLocation('us.alabama'),
            //     $this->getLocation('us.kentucky.jefferson_county'),
            //     0,
            //     0,
            //     250,
            //     1.06,
            // ],
            '9' => [
                'January 1, 2019 8am',
                $this->getLocation('us.alabama'),
                $this->getLocation('us.kentucky.jefferson_county'),
                0,
                0,
                300,
                4.35,
            ],
            // '10' => [
            //     'January 1, 2019 8am',
            //     $this->getLocation('us.alabama'),
            //     $this->getLocation('us.kentucky.jefferson_county'),
            //     0,
            //     0,
            //     700,
            //     3.50,
            // ],
            // '11' => [
            //     'January 1, 2019 8am',
            //     $this->getLocation('us.alabama'),
            //     $this->getLocation('us.kentucky.jefferson_county'),
            //     0,
            //     0,
            //     900,
            //     4.50,
            // ],
        ];
    }
}
