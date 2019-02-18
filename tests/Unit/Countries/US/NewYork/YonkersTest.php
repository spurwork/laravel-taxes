<?php

namespace Appleton\Taxes\Countries\US\NewYork\Yonkers;

use Appleton\Taxes\Countries\US\NewYork\NewYorkIncome\NewYorkIncome;
use Appleton\Taxes\Models\Countries\US\NewYork\NewYorkIncomeTaxInformation;
use Carbon\Carbon;

class YonkersTest extends \TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testYonkers($date, $home_location, $work_location, $filing_status, $exemptions, $earnings, $result)
    {
        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        NewYorkIncomeTaxInformation::forUser($this->user)
            ->update([
                'exemptions' => $exemptions,
                'filing_status' => $filing_status,
            ]);

        $results = $this->taxes->calculate(function ($taxes) use ($home_location, $work_location, $earnings) {
            $taxes->setHomeLocation($home_location);
            $taxes->setWorkLocation($work_location);
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame($result, $results->getTax(Yonkers::class));
    }

    public function provideTestData()
    {
        return [
            '0' => [
                'January 1, 2019 8am',
                $this->getLocation('us.new_york.yonkers'),
                $this->getLocation('us.new_york.yonkers'),
                NewYorkIncome::FILING_SINGLE,
                0,
                145,
                0.1,
            ],
            '1' => [
                'January 1, 2019 8am',
                $this->getLocation('us.new_york.yonkers'),
                $this->getLocation('us.new_york.yonkers'),
                NewYorkIncome::FILING_SINGLE,
                0,
                300,
                6.3,
            ],
            '2' => [
                'January 1, 2019 8am',
                $this->getLocation('us.new_york.yonkers'),
                $this->getLocation('us.new_york.yonkers'),
                NewYorkIncome::FILING_SINGLE,
                2,
                500,
                14.6,
            ],
            '3' => [
                'January 1, 2019 8am',
                $this->getLocation('us.new_york.yonkers'),
                $this->getLocation('us.new_york.yonkers'),
                NewYorkIncome::FILING_SINGLE,
                3,
                700,
                25.63,
            ],
            '4' => [
                'January 1, 2019 8am',
                $this->getLocation('us.new_york.yonkers'),
                $this->getLocation('us.new_york.yonkers'),
                NewYorkIncome::FILING_SINGLE,
                3,
                900,
                38.29,
            ],
            '5' => [
                'January 1, 2019 8am',
                $this->getLocation('us.new_york.yonkers'),
                $this->getLocation('us.new_york.yonkers'),
                NewYorkIncome::FILING_SINGLE,
                2,
                1300,
                64.83,
            ],
            '6' => [
                'January 1, 2019 8am',
                $this->getLocation('us.new_york.yonkers'),
                $this->getLocation('us.new_york.yonkers'),
                NewYorkIncome::FILING_SINGLE,
                11,
                1000,
                34.88,
            ],
            '7' => [
                'January 1, 2019 8am',
                $this->getLocation('us.new_york.yonkers'),
                $this->getLocation('us.new_york.yonkers'),
                NewYorkIncome::FILING_MARRIED,
                0,
                145,
                0.0,
            ],
            '8' => [
                'January 1, 2019 8am',
                $this->getLocation('us.new_york.yonkers'),
                $this->getLocation('us.new_york.yonkers'),
                NewYorkIncome::FILING_MARRIED,
                0,
                300,
                5.88,
            ],
            '9' => [
                'January 1, 2019 8am',
                $this->getLocation('us.new_york.yonkers'),
                $this->getLocation('us.new_york.yonkers'),
                NewYorkIncome::FILING_MARRIED,
                2,
                500,
                13.97,
            ],
            '10' => [
                'January 1, 2019 8am',
                $this->getLocation('us.new_york.yonkers'),
                $this->getLocation('us.new_york.yonkers'),
                NewYorkIncome::FILING_MARRIED,
                3,
                700,
                24.96,
            ],
            '11' => [
                'January 1, 2019 8am',
                $this->getLocation('us.new_york.yonkers'),
                $this->getLocation('us.new_york.yonkers'),
                NewYorkIncome::FILING_MARRIED,
                3,
                900,
                37.62,
            ],
            '12' => [
                'January 1, 2019 8am',
                $this->getLocation('us.new_york.yonkers'),
                $this->getLocation('us.new_york.yonkers'),
                NewYorkIncome::FILING_MARRIED,
                2,
                2000,
                109.10,
            ],
            '13' => [
                'January 1, 2019 8am',
                $this->getLocation('us.new_york.yonkers'),
                $this->getLocation('us.new_york.yonkers'),
                NewYorkIncome::FILING_MARRIED,
                11,
                1000,
                34.22,
            ],
        ];
    }
}
