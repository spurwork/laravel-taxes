<?php

namespace Appleton\Taxes\Unit\Countries\US\Idaho\IdahoIncome;

use Appleton\Taxes\Countries\US\Idaho\IdahoIncome\IdahoIncome;
use Appleton\Taxes\Models\Countries\US\Idaho\IdahoIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class IdahoIncomeTest extends TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testIdahoIncome($date, $exempt, $filing_status, $exemptions, $additional_withholding, $earnings, $result)
    {
        IdahoIncomeTaxInformation::forUser($this->user)->update([
            'exemptions' => $exemptions,
            'exempt' => $exempt,
            'filing_status' => $filing_status,
            'additional_withholding' => $additional_withholding,
        ]);

        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) use ($earnings) {
            $taxes->setHomeLocation($this->getLocation('us.idaho'));
            $taxes->setWorkLocation($this->getLocation('us.idaho'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame($result, $results->getTax(IdahoIncome::class));
    }

    public function provideTestData()
    {
        // date
        // exempt
        // exemptions
        // earnings
        // results
        return [
            // exempt, should be null
            '0' => [
                'January 1, 2019 8am',
                true,
                IdahoIncome::FILING_SINGLE,
                0,
                0,
                300,
                null,
            ],
            '1' => [
                'January 1, 2019 8am',
                false,
                IdahoIncome::FILING_SINGLE,
                0,
                0,
                300,
                1,
            ],
            '2' => [
                'January 1, 2019 8am',
                false,
                IdahoIncome::FILING_SINGLE,
                2,
                0,
                500,
                6,
            ],
            '3' => [
                'January 1, 2019 8am',
                false,
                IdahoIncome::FILING_SINGLE,
                4,
                0,
                1500,
                67,
            ],
            '4' => [
                'January 1, 2019 8am',
                false,
                IdahoIncome::FILING_MARRIED,
                0,
                0,
                300,
                null,
            ],
            '5' => [
                'January 1, 2019 8am',
                false,
                IdahoIncome::FILING_MARRIED,
                2,
                0,
                500,
                null,
            ],
            '6' => [
                'January 1, 2019 8am',
                false,
                IdahoIncome::FILING_MARRIED,
                4,
                0,
                1500,
                45,
            ],
            '7' => [
                'January 1, 2019 8am',
                false,
                IdahoIncome::FILING_HEAD_OF_HOUSEHOLD,
                0,
                0,
                300,
                1,
            ],
            '8' => [
                'January 1, 2019 8am',
                false,
                IdahoIncome::FILING_HEAD_OF_HOUSEHOLD,
                2,
                0,
                500,
                6,
            ],
            '9' => [
                'January 1, 2019 8am',
                false,
                IdahoIncome::FILING_HEAD_OF_HOUSEHOLD,
                4,
                0,
                1500,
                67,
            ],
        ];
    }
}
