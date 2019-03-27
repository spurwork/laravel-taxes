<?php

namespace Appleton\Taxes\Unit\Countries\US\Maryland;

use Appleton\Taxes\Countries\US\Maryland\Allegany\Allegany;
use Appleton\Taxes\Countries\US\Maryland\AnneArundel\AnneArundel;
use Appleton\Taxes\Countries\US\Maryland\Baltimore\Baltimore;
use Appleton\Taxes\Countries\US\Maryland\BaltimoreCity\BaltimoreCity;
use Appleton\Taxes\Countries\US\Maryland\Calvert\Calvert;
use Appleton\Taxes\Countries\US\Maryland\Caroline\Caroline;
use Appleton\Taxes\Countries\US\Maryland\Carroll\Carroll;
use Appleton\Taxes\Countries\US\Maryland\Cecil\Cecil;
use Appleton\Taxes\Countries\US\Maryland\Charles\Charles;
use Appleton\Taxes\Countries\US\Maryland\Dorchester\Dorchester;
use Appleton\Taxes\Countries\US\Maryland\Frederick\Frederick;
use Appleton\Taxes\Countries\US\Maryland\Garrett\Garrett;
use Appleton\Taxes\Countries\US\Maryland\Harford\Harford;
use Appleton\Taxes\Countries\US\Maryland\Howard\Howard;
use Appleton\Taxes\Countries\US\Maryland\Kent\Kent;
use Appleton\Taxes\Countries\US\Maryland\MarylandIncome\MarylandIncome;
use Appleton\Taxes\Countries\US\Maryland\Montgomery\Montgomery;
use Appleton\Taxes\Countries\US\Maryland\PrinceGeorges\PrinceGeorges;
use Appleton\Taxes\Countries\US\Maryland\QueenAnnes\QueenAnnes;
use Appleton\Taxes\Countries\US\Maryland\Somerset\Somerset;
use Appleton\Taxes\Countries\US\Maryland\StMarys\StMarys;
use Appleton\Taxes\Countries\US\Maryland\Talbot\Talbot;
use Appleton\Taxes\Countries\US\Maryland\Washington\Washington;
use Appleton\Taxes\Countries\US\Maryland\Wicomico\Wicomico;
use Appleton\Taxes\Countries\US\Maryland\Worcester\Worcester;
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
                2.05,
                Allegany::class,
            ],
            '9' => [
                'January 1, 2019 8am',
                MarylandIncome::FILING_SINGLE,
                'us.maryland.annearundel',
                'us.maryland',
                2,
                1000.00,
                20.84,
                AnneArundel::class,
            ],
            '10' => [
                'January 1, 2019 8am',
                MarylandIncome::FILING_SINGLE,
                'us.maryland.baltimore',
                'us.maryland',
                2,
                2000.00,
                51.89,
                Baltimore::class,
            ],
            '11' => [
                'January 1, 2019 8am',
                MarylandIncome::FILING_SINGLE,
                'us.maryland.baltimorecity',
                'us.maryland',
                0,
                1000.00,
                30.61,
                BaltimoreCity::class,
            ],
            '12' => [
                'January 1, 2019 8am',
                MarylandIncome::FILING_SINGLE,
                'us.maryland.calvert',
                'us.maryland',
                2,
                1000.00,
                25.00,
                Calvert::class,
            ],
            '13' => [
                'January 1, 2019 8am',
                MarylandIncome::FILING_SINGLE,
                'us.maryland.caroline',
                'us.maryland',
                0,
                2000.00,
                62.61,
                Caroline::class,
            ],
            '14' => [
                'January 1, 2019 8am',
                MarylandIncome::FILING_SINGLE,
                'us.maryland.carroll',
                'us.maryland',
                2,
                2000.00,
                55.55,
                Carroll::class,
            ],
            '15' => [
                'January 1, 2019 8am',
                MarylandIncome::FILING_SINGLE,
                'us.maryland.cecil',
                'us.maryland',
                0,
                100.00,
                2.13,
                Cecil::class,
            ],
            '16' => [
                'January 1, 2019 8am',
                MarylandIncome::FILING_SINGLE,
                'us.maryland.charles',
                'us.maryland',
                0,
                100.00,
                2.25,
                Charles::class,
            ],
            '17' => [
                'January 1, 2019 8am',
                MarylandIncome::FILING_SINGLE,
                'us.maryland.dorchester',
                'us.maryland',
                0,
                100.00,
                1.86,
                Dorchester::class,
            ],
            '18' => [
                'January 1, 2019 8am',
                MarylandIncome::FILING_SINGLE,
                'us.maryland.frederick',
                'us.maryland',
                0,
                100.00,
                2.10,
                Frederick::class,
            ],
            '19' => [
                'January 1, 2019 8am',
                MarylandIncome::FILING_SINGLE,
                'us.maryland.garrett',
                'us.maryland',
                0,
                100.00,
                1.88,
                Garrett::class,
            ],
            '20' => [
                'January 1, 2019 8am',
                MarylandIncome::FILING_SINGLE,
                'us.maryland.harford',
                'us.maryland',
                0,
                100.00,
                2.17,
                Harford::class,
            ],
            '21' => [
                'January 1, 2019 8am',
                MarylandIncome::FILING_SINGLE,
                'us.maryland.howard',
                'us.maryland',
                0,
                100.00,
                2.27,
                Howard::class,
            ],
            '22' => [
                'January 1, 2019 8am',
                MarylandIncome::FILING_SINGLE,
                'us.maryland.kent',
                'us.maryland',
                0,
                100.00,
                2.02,
                Kent::class,
            ],
            '23' => [
                'January 1, 2019 8am',
                MarylandIncome::FILING_SINGLE,
                'us.maryland.montgomery',
                'us.maryland',
                0,
                100.00,
                2.27,
                Montgomery::class,
            ],
            '24' => [
                'January 1, 2019 8am',
                MarylandIncome::FILING_SINGLE,
                'us.maryland.princegeorges',
                'us.maryland',
                0,
                100.00,
                2.27,
                PrinceGeorges::class,
            ],
            '25' => [
                'January 1, 2019 8am',
                MarylandIncome::FILING_SINGLE,
                'us.maryland.queenannes',
                'us.maryland',
                0,
                100.00,
                2.27,
                QueenAnnes::class,
            ],
            '26' => [
                'January 1, 2019 8am',
                MarylandIncome::FILING_SINGLE,
                'us.maryland.stmarys',
                'us.maryland',
                0,
                100.00,
                2.13,
                StMarys::class,
            ],
            '27' => [
                'January 1, 2019 8am',
                MarylandIncome::FILING_SINGLE,
                'us.maryland.somerset',
                'us.maryland',
                0,
                100.00,
                2.27,
                Somerset::class,
            ],
            '28' => [
                'January 1, 2019 8am',
                MarylandIncome::FILING_SINGLE,
                'us.maryland.talbot',
                'us.maryland',
                0,
                100.00,
                1.70,
                Talbot::class,
            ],
            '29' => [
                'January 1, 2019 8am',
                MarylandIncome::FILING_SINGLE,
                'us.maryland.washington',
                'us.maryland',
                0,
                100.00,
                1.99,
                Washington::class,
            ],
            '30' => [
                'January 1, 2019 8am',
                MarylandIncome::FILING_SINGLE,
                'us.maryland.wicomico',
                'us.maryland',
                0,
                100.00,
                2.27,
                Wicomico::class,
            ],
            '31' => [
                'January 1, 2019 8am',
                MarylandIncome::FILING_SINGLE,
                'us.maryland.worcester',
                'us.maryland',
                0,
                100.00,
                1.24,
                Worcester::class,
            ],
        ];
    }
}