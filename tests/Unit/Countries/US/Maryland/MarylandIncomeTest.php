<?php

namespace Appleton\Taxes\Unit\Countries\US\Maryland;

use Appleton\Taxes\Countries\US\Maryland\Allegany\Allegany;
use Appleton\Taxes\Countries\US\Maryland\MarylandIncome\MarylandIncome;
use Appleton\Taxes\Models\Countries\US\Maryland\MarylandIncomeTaxInformation;
use Carbon\Carbon;
use Nexmo\Message\Shortcode\Alert;
use TestCase;

class MarylandIncomeTest extends TestCase
{
    private const PAY_PERIODS = 52;

    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    public function testMarylandIncomeDefault()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.maryland'));
            $taxes->setWorkLocation($this->getLocation('us.maryland'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100.00);
            $taxes->setPayPeriods(self::PAY_PERIODS);
        });

        $this->assertThat(3.37, self::identicalTo($results->getTax(MarylandIncome::class)));
    }

    public function testMarylandIncomeSingleOverOneHundredThousandWithDependants()
    {
        MarylandIncomeTaxInformation::forUser($this->user)->update([
            'additional_withholding' => 0,
            'dependents' => 1,
            'filing_status' => MarylandIncome::FILING_SINGLE,
            'exempt' => false,
        ]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.maryland'));
            $taxes->setWorkLocation($this->getLocation('us.maryland'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2000.00);
            $taxes->setPayPeriods(self::PAY_PERIODS);
        });

        $this->assertThat(90.02, self::identicalTo($results->getTax(MarylandIncome::class)));
    }

    public function testMarylandIncomeWorkInDelaware()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.maryland'));
            $taxes->setWorkLocation($this->getLocation('us.delaware'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100.00);
            $taxes->setPayPeriods(self::PAY_PERIODS);
        });

        $this->assertThat(4.83, self::identicalTo($results->getTax(MarylandIncome::class)));
    }

    public function testAllegany()
    {
        MarylandIncomeTaxInformation::forUser($this->user)->update([
            'additional_withholding' => 0,
            'dependents' => 0,
            'filing_status' => MarylandIncome::FILING_SINGLE,
            'exempt' => false,
        ]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.maryland.allegany'));
            $taxes->setWorkLocation($this->getLocation('us.maryland'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300.00);
            $taxes->setPayPeriods(self::PAY_PERIODS);
        });

        $this->assertThat(7.83, self::identicalTo($results->getTax(Allegany::class)));
    }

    /**
     * @dataProvider provideTestData
     */
    public function testIncome($date, $filing_status, $home_location, $work_location, $exemptions, $earnings, $result, $tax_class)
    {
        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        MarylandIncomeTaxInformation::forUser($this->user)->update([
            'additional_withholding' => 0,
            'dependents' => $exemptions,
            'filing_status' => $filing_status,
            'exempt' => false,
        ]);

        $results = $this->taxes->calculate(function ($taxes) use ($earnings, $home_location, $work_location, $tax_class) {
            $taxes->setHomeLocation($this->getLocation($home_location));
            $taxes->setWorkLocation($this->getLocation($work_location));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setPayPeriods(self::PAY_PERIODS);
        });

        $this->assertSame($result, $results->getTax($tax_class));
    }

    public function provideTestData()
    {
        return [
            '0' => [
                'January 1, 2019 8am',
                MarylandIncome::FILING_SINGLE,
                'us.maryland',
                'us.maryland',
                0,
                300.00,
                12.19,
                MarylandIncome::class,
            ],
            '1' => [
                'January 1, 2019 8am',
                MarylandIncome::FILING_SINGLE,
                'us.maryland',
                'us.maryland',
                2,
                1000.00,
                39.59,
                MarylandIncome::class,
            ],
            '2' => [
                'January 1, 2019 8am',
                MarylandIncome::FILING_SINGLE,
                'us.maryland',
                'us.maryland',
                2,
                2000.00,
                87.09,
                MarylandIncome::class,
            ],
            '3' => [
                'January 1, 2019 8am',
                MarylandIncome::FILING_MARRIED_HEAD_OF_HOUSEHOLD,
                'us.maryland',
                'us.maryland',
                0,
                1000.00,
                45.44,
                MarylandIncome::class,
            ],
            '4' => [
                'January 1, 2019 8am',
                MarylandIncome::FILING_MARRIED_HEAD_OF_HOUSEHOLD,
                'us.maryland',
                'us.maryland',
                2,
                1000.00,
                39.59,
                MarylandIncome::class,
            ],
            '5' => [
                'January 1, 2019 8am',
                MarylandIncome::FILING_MARRIED_HEAD_OF_HOUSEHOLD,
                'us.maryland',
                'us.maryland',
                0,
                2000.00,
                92.94,
                MarylandIncome::class,
            ],
            '6' => [
                'January 1, 2019 8am',
                MarylandIncome::FILING_MARRIED_HEAD_OF_HOUSEHOLD,
                'us.maryland',
                'us.maryland',
                2,
                2000.00,
                87.09,
                MarylandIncome::class,
            ],
            '7' => [
                'January 1, 2019 8am',
                MarylandIncome::FILING_SINGLE,
                'us.maryland',
                'us.maryland',
                0,
                100.00,
                3.37,
                MarylandIncome::class,
            ],
            '8' => [
                'January 1, 2019 8am',
                MarylandIncome::FILING_SINGLE,
                'us.maryland.allegany',
                'us.maryland',
                0,
                300.00,
                7.83,
                Allegany::class,
            ],
        ];
    }
}