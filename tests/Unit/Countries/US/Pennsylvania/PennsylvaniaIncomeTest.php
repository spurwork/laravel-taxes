<?php

namespace Appleton\Taxes\Unit\Countries\US\Pennsylvania\PennsylvaniaIncome;

use Appleton\Taxes\Countries\US\Pennsylvania\PennsylvaniaIncome\PennsylvaniaIncome;
use Appleton\Taxes\Models\Countries\US\Pennsylvania\PennsylvaniaIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class PennsylvaniaIncomeTest extends TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testPennsylvaniaIncome($date, $exempt, $earnings, $result)
    {
        PennsylvaniaIncomeTaxInformation::forUser($this->user)->update([
            'exempt' => $exempt,
        ]);

        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) use ($earnings) {
            $taxes->setHomeLocation($this->getLocation('us.pennsylvania'));
            $taxes->setWorkLocation($this->getLocation('us.pennsylvania'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame($result, $results->getTax(PennsylvaniaIncome::class));
    }

    public function provideTestData()
    {
        // date
        // exempt
        // earnings
        // results
        return [
            // exempt, should be null
            '0' => [
                'January 1, 2019 8am',
                true,
                300,
                null,
            ],
            '1' => [
                'January 1, 2019 8am',
                false,
                50,
                1.54,
            ],
            '2' => [
                'January 1, 2019 8am',
                false,
                300,
                9.21,
            ],
            '3' => [
                'January 1, 2019 8am',
                false,
                2000,
                61.4,
            ],
        ];
    }
}
