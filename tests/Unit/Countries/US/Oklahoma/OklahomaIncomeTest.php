<?php

namespace Appleton\Taxes\Unit\Countries\US\Oklahoma\OklahomaIncome;

use Appleton\Taxes\Countries\US\Oklahoma\OklahomaIncome\OklahomaIncome;
use Appleton\Taxes\Models\Countries\US\Oklahoma\OklahomaIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class OklahomaIncomeTest extends TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testOklahomaIncome($date, $filing_status, $exempt, $dependents, $earnings, $result)
    {
        OklahomaIncomeTaxInformation::forUser($this->user)->update([
            'dependents' => $dependents,
            'exempt' => $exempt,
            'filing_status' => $filing_status,
        ]);

        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) use ($earnings) {
            $taxes->setHomeLocation($this->getLocation('us.oklahoma'));
            $taxes->setWorkLocation($this->getLocation('us.oklahoma'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame($result, $results->getTax(OklahomaIncome::class));
    }

    public function provideTestData()
    {
        // date
        // filing status
        // exempt
        // dependents
        // earnings
        // results
        return [
            // exempt, should be null
            '0' => [
                'January 1, 2019 8am',
                OklahomaIncome::FILING_SINGLE,
                true,
                0,
                300,
                0.0,
            ],
            '1' => [
                'January 1, 2019 8am',
                OklahomaIncome::FILING_SINGLE,
                false,
                0,
                300,
                5,
            ],
            '2' => [
                'January 1, 2019 8am',
                OklahomaIncome::FILING_SINGLE,
                false,
                2,
                1000,
                38,
            ],
            '3' => [
                'January 1, 2019 8am',
                OklahomaIncome::FILING_SINGLE,
                false,
                9,
                288.46,
                0,
            ],
            '4' => [
                'January 1, 2019 8am',
                OklahomaIncome::FILING_MARRIED,
                false,
                0,
                300,
                0,
            ],
            '5' => [
                'January 1, 2019 8am',
                OklahomaIncome::FILING_MARRIED,
                false,
                2,
                1000,
                29,
            ],
            '6' => [
                'January 1, 2019 8am',
                OklahomaIncome::FILING_MARRIED,
                false,
                9,
                288.46,
                0,
            ],
        ];
    }
}
