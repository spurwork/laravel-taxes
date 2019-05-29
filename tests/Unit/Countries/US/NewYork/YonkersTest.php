<?php

namespace Appleton\Taxes\Countries\US\NewYork\Yonkers;

use Appleton\Taxes\Countries\US\NewYork\NewYorkIncome\NewYorkIncome;
use Appleton\Taxes\Countries\US\NewYork\Yonkers\Yonkers;
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
                4,
                1000,
                7.20,
            ],
            '1' => [
                'January 1, 2019 8am',
                $this->getLocation('us.new_york.yonkers'),
                $this->getLocation('us.new_york.yonkers'),
                NewYorkIncome::FILING_SINGLE,
                2,
                500,
                2.45,
            ],
            '2' => [
                'January 1, 2019 8am',
                $this->getLocation('us.new_york.yonkers'),
                $this->getLocation('us.new_york.yonkers'),
                NewYorkIncome::FILING_SINGLE,
                12,
                500,
                0.85,
            ],
            '3' => [
                'January 1, 2019 8am',
                $this->getLocation('us.new_york.yonkers'),
                $this->getLocation('us.new_york.yonkers'),
                NewYorkIncome::FILING_MARRIED,
                3,
                700,
                4.17,
            ],
            '4' => [
                'January 1, 2019 8am',
                $this->getLocation('us.new_york.yonkers'),
                $this->getLocation('us.new_york.yonkers'),
                NewYorkIncome::FILING_MARRIED,
                5,
                900,
                5.85,
            ],
            '5' => [
                'January 1, 2019 8am',
                $this->getLocation('us.new_york.yonkers'),
                $this->getLocation('us.new_york.yonkers'),
                NewYorkIncome::FILING_MARRIED,
                2,
                2000,
                18.01,
            ],
            '6' => [
                'January 1, 2019 8am',
                $this->getLocation('us.new_york.yonkers'),
                $this->getLocation('us.new_york.yonkers'),
                NewYorkIncome::FILING_MARRIED,
                11,
                1000,
                5.69,
            ],
            '7' => [
                'January 1, 2019 8am',
                $this->getLocation('us.alabama'),
                $this->getLocation('us.new_york.yonkers'),
                NewYorkIncome::FILING_SINGLE,
                0,
                50,
                0.0,
            ],
            '8' => [
                'January 1, 2019 8am',
                $this->getLocation('us.alabama'),
                $this->getLocation('us.new_york.yonkers'),
                NewYorkIncome::FILING_SINGLE,
                0,
                250,
                1.06,
            ],
            '9' => [
                'January 1, 2019 8am',
                $this->getLocation('us.alabama'),
                $this->getLocation('us.new_york.yonkers'),
                NewYorkIncome::FILING_SINGLE,
                0,
                500,
                2.40,
            ],
            '10' => [
                'January 1, 2019 8am',
                $this->getLocation('us.alabama'),
                $this->getLocation('us.new_york.yonkers'),
                NewYorkIncome::FILING_SINGLE,
                0,
                700,
                3.50,
            ],
            '11' => [
                'January 1, 2019 8am',
                $this->getLocation('us.alabama'),
                $this->getLocation('us.new_york.yonkers'),
                NewYorkIncome::FILING_SINGLE,
                0,
                900,
                4.50,
            ],
        ];
    }
}
