<?php

namespace Appleton\Taxes\Unit\Countries\US\Maine\MaineIncome;

use Appleton\Taxes\Countries\US\Maine\MaineIncome\MaineIncome;
use Appleton\Taxes\Models\Countries\US\Maine\MaineIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class MaineIncomeTest extends TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testMaineIncome($date, $exempt, $filing_status, $allowances, $earnings, $result)
    {
        MaineIncomeTaxInformation::forUser($this->user)->update([
            'allowances' => $allowances,
            'exempt' => $exempt,
            'filing_status' => $filing_status,
        ]);

        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) use ($earnings) {
            $taxes->setHomeLocation($this->getLocation('us.maine'));
            $taxes->setWorkLocation($this->getLocation('us.maine'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame($result, $results->getTax(MaineIncome::class));
    }

    public function provideTestData()
    {
        // date
        // exempt
        // filing status
        // allowances
        // earnings
        // results
        return [
            // exempt, should be null
            '0' => [
                'January 1, 2019 8am',
                true,
                MaineIncome::FILING_SINGLE,
                0,
                300,
                null,
            ],
            '1' => [
                'January 1, 2019 8am',
                false,
                MaineIncome::FILING_SINGLE,
                2,
                300,
                null,
            ],
            '2' => [
                'January 1, 2019 8am',
                false,
                MaineIncome::FILING_SINGLE,
                0,
                300,
                7,
            ],
            '3' => [
                'January 1, 2019 8am',
                false,
                MaineIncome::FILING_SINGLE,
                2,
                1000,
                40,
            ],
            '4' => [
                'January 1, 2019 8am',
                false,
                MaineIncome::FILING_SINGLE,
                2,
                2000,
                114,
            ],
            '5' => [
                'January 1, 2019 8am',
                false,
                MaineIncome::FILING_MARRIED,
                2,
                1000,
                25,
            ],
            '6' => [
                'January 1, 2019 8am',
                false,
                MaineIncome::FILING_MARRIED,
                0,
                2000,
                99,
            ],
            '7' => [
                'January 1, 2019 8am',
                false,
                MaineIncome::FILING_MARRIED,
                2,
                2000,
                88,
            ],
            '8' => [
                'January 1, 2019 8am',
                false,
                MaineIncome::FILING_SINGLE,
                2,
                800,
                27,
            ],
            '9' => [
                'January 1, 2019 8am',
                false,
                MaineIncome::FILING_MARRIED,
                2,
                4500,
                279,
            ],
        ];
    }
}
