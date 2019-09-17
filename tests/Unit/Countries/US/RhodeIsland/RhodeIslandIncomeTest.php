<?php

namespace Appleton\Taxes\Unit\Countries\US\RhodeIsland\RhodeIslandIncome;

use Appleton\Taxes\Countries\US\RhodeIsland\RhodeIslandIncome\RhodeIslandIncome;
use Appleton\Taxes\Models\Countries\US\RhodeIsland\RhodeIslandIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class RhodeIslandIncomeTest extends TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testRhodeIslandIncome($date, $exempt, $exemptions, $earnings, $additional_withholding, $result)
    {
        RhodeIslandIncomeTaxInformation::forUser($this->user)->update([
            'exemptions' => $exemptions,
            'exempt' => $exempt,
            'additional_withholding' => $additional_withholding,
        ]);

        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) use ($earnings) {
            $taxes->setHomeLocation($this->getLocation('us.rhode_island'));
            $taxes->setWorkLocation($this->getLocation('us.rhode_island'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame($result, $results->getTax(RhodeIslandIncome::class));
    }

    public function provideTestData()
    {
        // date
        // exempt
        // exemptions
        // earnings
        // additional withholding
        // results
        return [
            // exempt, should be null
            '0' => [
                'January 1, 2019 8am',
                true,
                0,
                300,
                0,
                null,
            ],
            '1' => [
                'January 1, 2019 8am',
                false,
                0,
                300,
                0,
                11.25,
            ],
            '2' => [
                'January 1, 2019 8am',
                false,
                2,
                300,
                0,
                9.81,
            ],
            '3' => [
                'January 1, 2019 8am',
                false,
                0,
                1346.15,
                0,
                51.62,
            ],
            '4' => [
                'January 1, 2019 8am',
                false,
                2,
                1346.15,
                0,
                49.8,
            ],
            '5' => [
                'January 1, 2019 8am',
                false,
                2,
                1346.15,
                20,
                69.8,
            ],
        ];
    }
}
