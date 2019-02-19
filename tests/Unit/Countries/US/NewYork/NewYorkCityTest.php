<?php

namespace Appleton\Taxes\Countries\US\NewYork\NewYorkCity;

use Appleton\Taxes\Countries\US\NewYork\NewYorkIncome\NewYorkIncome;
use Appleton\Taxes\Models\Countries\US\NewYork\NewYorkIncomeTaxInformation;
use Carbon\Carbon;

class NewYorkCityTest extends \TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testNewYorkCity($date, $filing_status, $exemptions, $earnings, $result)
    {
        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        NewYorkIncomeTaxInformation::forUser($this->user)
            ->update([
                'exemptions' => $exemptions,
                'filing_status' => $filing_status,
            ]);

        $results = $this->taxes->calculate(function ($taxes) use ($earnings) {
            $taxes->setHomeLocation($this->getLocation('us.new_york'));
            $taxes->setWorkLocation($this->getLocation('us.new_york'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame($result, $results->getTax(NewYorkCity::class));
    }

    public function provideTestData()
    {
        return [
            '0' => [
                'January 1, 2019 8am',
                NewYorkIncome::FILING_SINGLE,
                4,
                1000,
                29.42,
            ],
            '1' => [
                'January 1, 2019 8am',
                NewYorkIncome::FILING_SINGLE,
                2,
                500,
                10.50,
            ],
            '2' => [
                'January 1, 2019 8am',
                NewYorkIncome::FILING_SINGLE,
                12,
                500,
                3.72,
            ],
            '3' => [
                'January 1, 2019 8am',
                NewYorkIncome::FILING_SINGLE,
                3,
                700,
                17.77,
            ],
            '4' => [
                'January 1, 2019 8am',
                NewYorkIncome::FILING_SINGLE,
                5,
                900,
                24.47,
            ],
            '5' => [
                'January 1, 2019 8am',
                NewYorkIncome::FILING_SINGLE,
                2,
                2000,
                73.24,
            ],
            '6' => [
                'January 1, 2019 8am',
                NewYorkIncome::FILING_SINGLE,
                11,
                1000,
                23.83,
            ],
        ];
    }
}
