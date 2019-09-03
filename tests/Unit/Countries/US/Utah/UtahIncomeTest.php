<?php

namespace Appleton\Taxes\Unit\Countries\US\Utah\UtahIncome;

use Appleton\Taxes\Countries\US\Utah\UtahIncome\UtahIncome;
use Appleton\Taxes\Models\Countries\US\Utah\UtahIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class UtahIncomeTest extends TestCase
{
    /**
    * @dataProvider provideTestData
    */
    public function testUtahIncome($date, $filing_status, $additional_withholding, $earnings, $result)
    {
        UtahIncomeTaxInformation::forUser($this->user)->update([
            'additional_withholding' => $additional_withholding,
            'filing_status' => $filing_status,
        ]);

        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) use ($earnings) {
            $taxes->setHomeLocation($this->getLocation('us.utah'));
            $taxes->setWorkLocation($this->getLocation('us.utah'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame($result, $results->getTax(UtahIncome::class));
    }

    public function provideTestData()
    {
        // date
        // filing status
        // additional withholding
        // earnings
        // results
        return [
            '0' => [
                'January 1, 2019 8am',
                UtahIncome::FILING_SINGLE,
                0,
                400,
                16.29,
            ],
            '1' => [
                'January 1, 2019 8am',
                UtahIncome::FILING_SINGLE,
                0,
                300,
                10.04,
            ],
            '2' => [
                'January 1, 2019 8am',
                UtahIncome::FILING_MARRIED,
                0,
                300,
                1.34,
            ],
            '3' => [
                'January 1, 2019 8am',
                UtahIncome::FILING_MARRIED,
                20,
                300,
                21.34,
            ],
        ];
    }
}
